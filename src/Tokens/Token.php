<?php
namespace VKBansal\Prism\Tokens;

use DOMDocument;
use VKBansal\Prism\Util;

/**
 * Token Class
 * @package VKBansal\Prism\Token
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
     * @var string|array|Token
     */
    public $content;

    /**
     * @var string
     */
    public $alias;

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
     * @var array
     */
    protected $attributes = [];

    /**
     * Constructor
     * @param string             $type
     * @param string|array|Token $content
     * @param null|string        $alias
     */
    public function __construct($type, $content, $language, $alias = null)
    {
        $this->type = $type;
        $this->content = $content;
        $this->language = $language;
        $this->alias = $alias;
    }

    /**
     * Detokenize
     * @param  string|array|Token $content
     * @param  string             $language
     * @param  null|string|array  $parent
     * @return DOMElement|DOMText|array<DOMElement|DOMText>
     */
    public function toNode(DOMDocument $parent)
    {   
        if (is_string($this->content)) {
            return $parent->createTextNode($this->content);
        }

        if (is_array($this->content)) {
            $temp = [];
            
            $count = count($this->content);
            
            for ($i = 0; $i < $count ; $i++) {
                $content = $this->content[$i]; 
                //var_dump($content);
                if(!$content){
                    continue;
                }
                $temp[] = $content->toNode($parent);
            }

            return $temp;
        }

        if ($this->type === 'comment') {
            $this->attributes['spellcheck'] = "true";
        }

        if (isset($this->alias)) {
            $aliases = is_array($this->alias) ? $this->alias : [$this->alias];
            $this->classes = array_merge($this->classes, $aliases);
        }

        $span = $parent->createElement($this->tag);
        $span->setAttribute('class', implode(" ", $this->classes));
        
        foreach ($this->attributes as $key => $value) {
            $span->setAttribute($key, $value);
        }

        $span->nodeValue = $this->content;
        
        return $span;
    }
}
