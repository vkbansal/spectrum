<?php
namespace VKBansal\Spectrum;

/**
 * Token Class
 * @package VKBansal\Spectrum\Token
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Token
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string|Token|array<Token|string|\DOMText>
     */
    private $content;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $tag = 'span';

    /**
     * @var array
     */
    private $classes = ['token'];

    /**
     * @var array<string>
     */
    private $attributes = [];

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
     * @param  \VKBansal\Spectrum\Spectrum $prism
     * @return \DOMElement
     */
    public function toNode(Spectrum $prism)
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

        Util::addClass($span, implode(" ", $this->classes));
        Util::setAttr($span , $this->attributes);
        Util::setInnerHTML($span, $this->content);

        return $span;
    }

    /**
     * Getter for Content
     * @return string|Token|array<Token|string|\DOMText>
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Process content
     * @param  \VKBansal\Spectrum\Spectrum $prism
     * @return array<\DOMText|\DOMElement>
     */
    private function finalizeContent(Spectrum $prism)
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
     * @param  \VKBansal\Spectrum\Spectrum $prism
     * @return array
     */
    private function processContentAsArray(Spectrum $prism)
    {
        $contents= array_filter($this->content);

        return array_map(function($content) use ($prism) {
            if ($content instanceof Token) {
                return $content->toNode($prism);
            } elseif (is_string($content)) {
                return $prism->getDocument()->createTextNode($content);
            } elseif ($content instanceof \DOMText) {
                return $content;
            }
        }, $contents);
    }
}
