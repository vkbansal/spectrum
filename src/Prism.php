<?php
namespace VKBansal\Prism;

use DOMDocument;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use VKBansal\Prism\Token\Generator;
use VKBansal\Prism\Hook\HookInterface;
use VKBansal\Prism\Hook\HookableTrait;
use VKBansal\Prism\Language\DefinitionInterface;
use VKBansal\Prism\Language\RepositoryTrait;

/**
 * Core Prism class for syntax highlighting
 * @package VKBansal\Prism\Prism
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Prism implements HookInterface, DefinitionInterface
{
    use HookableTrait;
    use Language\RepositoryTrait;

    /**
     * Stores HTML Document to be highlighted
     * @var DOMDocument
     */
    protected $document;

    /**
     * Regex for testing classes
     * @var string
     */
    protected $langTest = "/\blang(?:uage)?-(?!\*)(\w+)\b/i";

    /**
     * Class Constructor
     */
    public function __construct($path = null)
    {
        $file = is_null($path) ? __DIR__."/.lang.map.php" : $path;

        if (!file_exists($file)) {
            $mapping = $this->saveMap($file);
        } else {
            $mapping = require_once $file;
        }

        $this->map = $mapping['map'];
        $this->aliases = $mapping['aliases'];
        $this->defaults = $mapping['defaults'];

        $this->loadDefaultDefinitions();
    }

    /**
     * Highlights all the code blocks in given HTML
     * @param string  $html   HTML to be highlighted
     * @param boolean $encode Whether input (HTML entities) should be encoded. Default true.
     *                        Can be turned off in case input is already encoded to boost performance.
     * @param boolean $decode Whether output (HTML entities) should be decoded. Default false.
     * @return string
     */
    public function highlightHTML($html, $encode = true, $decode = false)
    {
        $this->document = new DOMDocument();
        $this->document->encoding = 'utf-8';

        $html = $encode ? Util::encodeCodeBlocks($html) : $html;

        $this->document->loadHTML($html);

        $crawler = new Crawler($this->document);

        $nodes = $crawler->filter('code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code');

        foreach ($nodes as $node) {
            $this->highlightElement($node);
        }

        $html = $this->document->saveHTML();

        return $decode ? Util::decodeCodeBlocks($html): $html;
    }

    /**
     * Highlight given text
     * @param  string $text     Text to be highlighted
     * @param  string $language Language to be used
     * @return string           Highlighted text (HTML)
     */
    public function highlightText($text, $language)
    {
        $this->document = new DOMDocument();
        $this->document->encoding = 'utf-8';

        $text = Util::encodeCodeBlocks($text);
        $grammar = $this->getDefinition($language);
        $nodes = $this->highlight($text, $grammar, $language);

        foreach ($nodes as $node) {
            $this->document->appendChild($node);
        }
        return $this->document->saveHTML();
    }

    /**
     * Highlights given element
     * @param  DOMElement $element
     * @return string
     */
    public function highlightElement(DOMElement $element)
    {
        $language = null;
        $grammar = null;
        $parent = $this->getParent($element);

        if ($parent) {
            $language = $this->detectLanguage($element);
            $grammar = $this->getDefinition($language);
        }

        if (!$grammar) {
            return false;
        }

        $this->addClass($element, 'language-'.$language);

        $parent = $element->parentNode;

        if (preg_match("/pre/i", $parent->nodeName) === 1) {
            $this->addClass($parent, 'language-'.$language);
        }

        $code = Util::decodeHTML($this->getInnerHTML($element));

        if (!$code) {
            return false;
        }

        $env = [
            'element' => &$element,
            'language' => $language,
            'grammar' => $grammar,
            'code' => &$code
        ];

        $this->runHook('before.highlight', $env);

        $nodes = $this->highlight($code, $grammar, $language);

        $this->runHook('before.insert', $env);

        $this->setInnerHtml($element, $nodes);

        $this->runHook('after.highlight', $env);

        return $element->ownerDocument->saveHTML($element);
    }

    /**
     * Highlights given code with given grammar
     * @param  string $code
     * @param  array  $grammar
     * @param  string $language
     * @return array
     */
    public function highlight($code, $grammar, $language)
    {
        $generator = new Generator($code, $grammar, $language);
        $generator->generate();
        $nodes = $generator->toNodes($this);
        return is_array($nodes) ? $nodes : [$nodes];
    }

    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Gets Inner HTML
     * @param  DOMElement $node
     * @return string
     */
    protected function getInnerHTML(DOMElement $node)
    {
        $children = $node->childNodes;
        $innerHTML = "";

        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }

    /**
     * Set Inner HTML
     * @param DOMElement $element
     * @param array      $nodes
     */
    protected function setInnerHtml(DOMElement $element, array $nodes)
    {
        $element->nodeValue = "";

        foreach ($nodes as $node) {
            $element->appendChild($node);
        }

        return $element;
    }

    /**
     * Add class to an element
     * @param DOMElement $element
     * @param string     $newClassNames
     */
    protected function addClass(DOMElement $element, $newClassNames)
    {
        $className = $element->getAttribute('class');
        $className = preg_replace($this->langTest, '', $className);
        $className = preg_replace("/\s+/", ' ', $className).' '.$newClassNames;
        $element->setAttribute('class', $className);
    }

    /**
     * Detect language from class name in form of "language-{name}"
     * @param  DOMElement $element
     * @return string
     */
    protected function detectLanguage(DOMElement $element)
    {
        $class = $element->getAttribute('class');

        if (preg_match($this->langTest, $class, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Get parent which has class name in form of "language-{name}"
     * @param  DOMElement $element
     * @return \DOMNode
     */
    protected function &getParent(DOMElement $element)
    {
        while ($element && preg_match($this->langTest, $element->getAttribute('class')) !== 1) {
            $element = $element->parentNode;
        }
        return $element;
    }

    protected function saveMap($path)
    {
        $mapper = new Language\Mapper();
        $map = $mapper->getMap();
        $mapper->saveMap($path, $map);
        return $map;
    }
}
