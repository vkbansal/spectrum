<?php
namespace VKBansal\Prism;

use DOMDocument;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use VKBansal\Prism\Hooks\Hooks;
use VKBansal\Prism\Languages\Repository;
use VKBansal\Prism\Tokens\Generator;

/**
 * Core Prism class for syntax highliting
 * @package VKBansal\Prism\Prism
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Prism
{
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
     * Languages repository
     * @var \VKBansal\Prism\Languages\Repository
     */
    protected $repo;

    /**
     * Class Constructor
     * @param string|null path Path to language map
     */
    public function __construct($path = null)
    {
        $hooks = new Hooks();
        $this->repo = new Repository($hooks, $path);
    }

    /**
     * Load default languages description]
     * @return void
     */
    public function loadDefaultLanguages()
    {
        $this->repo->loadDefaultDefinitions();
    }

    /**
     * Add specified languages
     * @param string[] $langs
     */
    public function loadLanguages(array $langs)
    {
        foreach ($langs as $lang) {
            $this->repo->loadDefinition($lang);
        }
    }

    /**
     * Load all languages defined in map
     * @return void
     */
    public function loadAllLanguages()
    {
        $this->repo->loadAllDefinitions();
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
        $grammar = $this->getGrammar($language);
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
        $parent = $element;

        while ($parent && preg_match($this->langTest, $parent->getAttribute('class')) !== 1) {
            $parent = $parent->parentNode;
        }

        if ($parent) {
            $class = $parent->getAttribute('class');
            
            if (preg_match($this->langTest, $class, $matches) === 1) {
                $language = $matches[1];
            } else {
                $language = '';
            }

            $grammar = $this->getGrammar($language);
        }

        if (!isset($grammar) || is_null($grammar)) {
            return false;
        }

        $className = $element->getAttribute('class');
        $className = preg_replace($this->langTest, '', $className);
        $className = preg_replace("/\s+/", ' ', $className).' language-'.$language;
        $element->setAttribute('class', $className);

        $parent = $element->parentNode;

        if (preg_match("/pre/i", $parent->nodeName) === 1) {
            $className = $parent->getAttribute('class');
            $className = preg_replace($this->langTest, '', $className);
            $className = preg_replace("/\s+/", ' ', $className).' language-'.$language;
            $parent->setAttribute('class', $className);
        }

        $code = $this->getInnerHTML($element);

        if (!isset($code)) {
            return false;
        }

        $env = [
            'element' => &$element,
            'language' => $language,
            'grammar' => $grammar,
            'code' => $code
        ];

        $this->repo->runHook('before.highlight', $env);


        $nodes = $this->highlight($code, $grammar, $language);
        $element->nodeValue = "";

        $this->repo->runHook('before.insert', $env);

        foreach ($nodes as $node) {
            $element->appendChild($node);
        }

        $this->repo->runHook('after.highlight', $env);

        return $element->ownerDocument->saveHTML($element);
    }

    /**
     * Highlights given code with given grammar
     * @param  string $code
     * @param  array  $grammar
     * @param  string $language
     * @return array
     */
    protected function highlight($code, $grammar, $language)
    {
        //$tokens = Token::tokenize($code, $grammar);
        $generator = new Generator($code, $grammar, $language);
        $tokens = $generator->generate();
        $nodes = $generator->toNodes($this->document);
        return is_array($nodes) ? $nodes : [$nodes];
    }

    /**
     * Gets Grammar for the  specified language
     * @param  string
     * @return array
     */
    public function getGrammar($language = null)
    {
        if (!is_null($language)) {
            $this->repo->loadDefinition($language);
        }
        return $this->repo->getDefinition($language);
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
}
