<?php
namespace VKBansal\Prism\Token;

/**
 * Token Class
 * @package VKBansal\Prism\Token\Token
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Token
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string|Token|array<Token|string>
     */
    public $content;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    protected $tag = 'span';

    /**
     * @var array
     */
    protected $classes = ['token'];

    /**
     * @var array<string>
     */
    protected $attributes = [];

    /**
     * Constructor
     * @param string                           $type
     * @param string|Token|array<Token|string> $content
     * @param string                           $language
     * @param null|string                      $alias
     */
    public function __construct($type, $content, $language, $alias = null)
    {
        $this->type = $type;
        $this->classes[] = $type;
        $this->content = $content;
        $this->language = $language;
        $this->alias = $alias;
    }

    /**
     * Converts Token to DOMElement
     * @param  \DOMDocument $parent
     * @return \DOMElement
     */
    public function toNode(\DOMDocument $parent)
    {
        $this->finalizeContent($parent);

        if ($this->type === 'comment') {
            $this->attributes['spellcheck'] = "true";
        }

        if (!is_null($this->alias)) {
            $aliases = is_array($this->alias) ? $this->alias : [$this->alias];
            $this->classes = array_merge($this->classes, $aliases);
        }

        $span = $parent->createElement($this->tag);
        $span->setAttribute('class', implode(" ", $this->classes));
        
        foreach ($this->attributes as $key => $value) {
            $span->setAttribute($key, $value);
        }

        foreach ($this->content as $content) {
            $span->appendChild($content);
        }
        
        return $span;
    }

    /**
     * Process content
     * @param  \DOMDocument $parent
     * @return array<\DOMText|\DOMElement>
     */
    protected function finalizeContent(\DOMDocument $parent)
    {
        if (is_string($this->content)) {
            return $this->content = [$parent->createTextNode($this->content)];
        }

        if (is_array($this->content)) {
            $temp = [];
            
            $count = count($this->content);
            
            for ($i = 0; $i < $count; $i++) {
                $content = $this->content[$i];
                
                if (!$content) {
                    continue;
                }
                
                if ($content instanceof Token) {
                    $temp[] = $content->toNode($parent);
                } elseif (is_string($content)) {
                    $temp[] = $parent->createTextNode($content);
                } elseif ($content instanceof \DOMText) {
                    $temp[] = $content;
                }
            }

            return $this->content = $temp;
        }
    }
}
