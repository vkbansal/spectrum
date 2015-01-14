<?php
namespace VKBansal\Prism\Token;

use VKBansal\Prism\Prism;

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
     * @var string|Token|array<Token|string|\DOMText>
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
     * @param string                                    $type
     * @param string|Token|array<Token|string|\DOMText> $content
     * @param string                                    $language
     * @param null|string                               $alias
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
     * @param  \VKBansal\Prism\Prism $prism
     * @return \DOMElement
     */
    public function toNode(Prism $prism)
    {
        $this->finalizeContent($prism);

        if ($this->type === 'comment') {
            $this->attributes['spellcheck'] = "true";
        }

        if (!is_null($this->alias)) {
            $aliases = is_array($this->alias) ? $this->alias : [$this->alias];
            $this->classes = array_merge($this->classes, $aliases);
        }

        $span = $prism->getDocument()->createElement($this->tag);

        $env = [
            "type" => $this->type,
            "content" =>& $this->content,
            "tag" => $this->tag,
            "classes" =>& $this->classes,
            "attributes" =>& $this->attributes,
            "language" => $this->language,
            "parent" => $prism->getDocument()
        ];

        $prism->runHook('wrap', $env);

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
     * @param  \VKBansal\Prism\Prism $prism
     * @return array<\DOMText|\DOMElement>
     */
    protected function finalizeContent(Prism $prism)
    {
        if (is_string($this->content)) {
             return $this->content = [$prism->getDocument()->createTextNode($this->content)];
        }

        if (is_array($this->content)) {
            return $this->content = $this->processContentAsArray($prism);
        }

        return $this->content;
    }

    /**
     * Process content as array
     * @param  \VKBansal\Prism\Prism $prism
     * @return array
     */
    protected function processContentAsArray(Prism $prism)
    {
        $temp = [];

        foreach ($this->content as $content) {
            if (!$content) {
                continue;
            }

            if ($content instanceof Token) {
                $temp[] = $content->toNode($prism);
            } elseif (is_string($content)) {
                $temp[] = $prism->getDocument()->createTextNode($content);
            } elseif ($content instanceof \DOMText) {
                $temp[] = $content;
            }
        }
        return $temp;
    }
}
