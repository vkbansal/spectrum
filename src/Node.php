<?php
namespace VKBansal\Prism;

use DOMDocument;
use VKBansal\Prism\Token;

/**
 * Node Maker
 * @package VKBansal\Prism\Node
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Node
{
    /**
     * @var Token
     */
    protected $content;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var array|null
     */
    protected $parent;

    /**
     * @var string
     */
    protected $tag = 'span';

    /**
     * @var array
     */
    protected $classes = ['token'];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * constructor
     * @param Token      $content
     * @param string     $language
     * @param array|null $parent
     */
    public function __construct(Token $content, $language, $parent = null)
    {
        $this->content = $content;
        $this->classes[] = $content->type;
        $this->language = $language;
        $this->parent = $parent;
    }

    /**
     * Get language of node
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get DOMNode for node
     * @return DOMNode
     */
    public function getDOMNode()
    {
        $document = new \DOMDocument();
        
        $finalContent = Token::detokenize($this->content->content, $this->language, $this->parent);
        
        $finalContent = is_array($finalContent) ? $finalContent: [$finalContent];
        
        if ($this->content->type === 'comment') {
            $this->attributes['spellcheck'] = "true";
        }

        if (isset($this->content->alias)) {
            $aliases = is_array($this->content->alias) ? $this->content->alias : [$this->content->alias];
            $this->classes = array_merge($this->classes, $aliases);
        }

        $span = $document->createElement($this->tag);
        
        foreach ($finalContent as $node) {
            $span->appendChild($document->importNode($node, true));
        }

        $span->setAttribute('class', implode(" ", $this->classes));
       
        foreach ($this->attributes as $key => $value) {
            $span->setAttribute($key, $value);
        }
        return $span;
    }
}
