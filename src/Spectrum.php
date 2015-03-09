<?php
namespace VKBansal\Spectrum;

use DOMDocument;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;
use VKBansal\Spectrum\Hook\HookInterface;
use VKBansal\Spectrum\Language\DefinitionInterface;

/**
 * Core Spectrum class for syntax highlighting
 * @package VKBansal\Spectrum\Spectrum
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Spectrum implements HookInterface, DefinitionInterface
{
    use Hook\HookableTrait;
    use Language\RepositoryTrait;
    use Plugin\PluggableTrait;

    /**
     * Stores HTML Document to be highlighted
     * @var DOMDocument
     */
    private $document;

    /**
     * Regex for testing classes
     * @var string
     */
    private $langTest = "/\blang(?:uage)?-(?!\*)(\w+)\b/i";

    /**
     * Class Constructor
     */
    public function __construct($path = null)
    {
        list($this->map, $this->aliases, $this->defaults) = Language\Mapper::getMap();
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
        $this->loadDefinition($language);
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
        $parent = Util::getParent($element);

        if ($parent) {
            $language = Util::detectLanguage($element);
            $this->loadDefinition($language);
            $grammar = $this->getDefinition($language);
        }

        if (!$grammar) {
            return false;
        }

        Util::removeClass($element, $this->langTest, true);
        Util::addClass($element, 'language-'.$language);

        $parent = $element->parentNode;

        if (Util::isPre($parent)) {
            Util::removeClass($parent, $this->langTest, true);
            Util::addClass($parent, 'language-'.$language);
        }

        $code = Util::decodeHTML(Util::getInnerHTML($element));

        if (!$code) {
            return false;
        }

        $env = [
            'element' => &$element,
            'language' => $language,
            'grammar' => &$grammar,
            'code' => &$code
        ];

        $this->runHook('before.highlight', $env);

        $nodes = $this->highlight($code, $grammar, $language);

        $this->runHook('before.insert', $env);

        Util::setInnerHTML($element, $nodes);

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
        $lexer = new Lexer($code, $grammar, $language);
        $tokens = $lexer->tokenize();
        $nodes = $lexer->toNodes($this);
        return is_array($nodes) ? $nodes : [$nodes];
    }

    public function getDocument()
    {
        return $this->document;
    }

    public static function autoload()
    {
        spl_autoload_register(function ($class) {
            if (!preg_match("/^VKBansal\\\\Spectrum\\\\\\w+/", $class)) {
                return false;
            }

            $file = str_replace("VKBansal\Spectrum", "", $class);
            $file = realpath(__DIR__."{$file}.php");
            require_once($file);
        });
    }
}
