<?php
namespace VKBansal\Spectrum;

/**
 * Utility Class
 * @package VKBansal\Spectrum\Util
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Util
{
    /**
     * Regex for matching code tags
     * @var string
     */
    protected static $codeTagRegex = "/(\<code.*?>)(.*?)(\<\/code>)/is";

    /**
     * Regex for testing language classes
     * @var string
     */
    protected static $langTest = "/\blang(?:uage)?-(?!\*)(\w+)\b/i";

    /**
     * Check if given array is associative
     * @param  array   $arr
     * @return boolean
     */
    public static function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Encodes content within code blocks
     * @param  string $code HTML to be encoded
     * @return string       Encoded HTML
     */
    public static function encodeCodeBlocks($code)
    {
        return preg_replace_callback(self::$codeTagRegex, function ($match) {
            return $match[1].self::encodeHTML($match[2]).$match[3];
        }, $code);
    }

    /**
     * Decode content within code blocks
     * @param  string $code HTML to be decoded
     * @return string       Decoded HTML
     */
    public static function decodeCodeBlocks($code)
    {
        return preg_replace_callback(self::$codeTagRegex, function ($match) {
            return $match[1].self::decodeHTML($match[2]).$match[3];
        }, $code);
    }

    /**
     * Encodes HTML String. Replaces "'&', '<' and ''>'" with "'&amp;', '&lt;' and '&gt;'" respectively
     * @param  string $code HTML to be encoded
     * @return string       Encoded HTML
     */
    public static function encodeHTML($code)
    {
        return preg_replace(["/\&/", "/\</", "/>/"], ["&amp;", "&lt;", "&gt;"], $code);
    }

    /**
     * Decodes HTML String. Inverse of Util::encodeHTML()
     * @param  string $code HTML to be decoded
     * @return string       Decoded HTML
     */
    public static function decodeHTML($code)
    {
        return preg_replace(["/\&amp;/", "/\&lt;/", "/\&gt;/"], ["&", "<", ">"], $code);
    }

    /**
     * Gets Inner HTML
     * @param  \DOMElement $node
     * @return string
     */
    public static function getInnerHTML(\DOMElement $node)
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
     * @param \DOMElement $element
     * @param array      $nodes
     */
    public static function setInnerHtml(\DOMElement $element, array $nodes)
    {
        $element->nodeValue = "";

        foreach ($nodes as $node) {
            $element->appendChild($node);
        }

        return $element;
    }

    /**
     * Add class to an element
     * @param \DOMElement $element
     * @param string     $newClassNames
     */
    public static function addClass(\DOMElement $element, $newClassNames)
    {
        $className = $element->getAttribute('class');
        $className .= " {$newClassNames}";
        $className = trim($className);
        $element->setAttribute('class', $className);
    }

    /**
     * Remove class from an element
     * @param  \DOMElement $element
     * @param  string      $classes
     * @param  boolean     $isRegex
     * @return void
     */
    public static function removeClass(\DOMElement $element, $classes, $isRegex = false)
    {
        $classList = $element->getAttribute('class');

        if ($isRegex) {
            $classList = preg_replace($classes, "", $classList);
        } else {
            $classList = explode(" ", $classList);
            $classes = explode(" ", $classes);
            $classList = array_diff($classList, $classes);
            $classList = implode(" ", $classList);
        }

        $classList = preg_replace("/\s+/", ' ', $classList);
        $classList = trim($classList);
        $element->setAttribute('class', $classList);
    }

    /**
     * Set Attributes on an element
     * @param \DOMElement $element
     * @param array       $attrs
     */
    public static function setAttr(\DOMElement $element, array $attrs)
    {
        foreach ($attrs as $key => $value) {
            $element->setAttribute($key, $value);
        }
        return $element;
    }

    /**
     * Detect language from class name in form of "language-{name}"
     * @param  \DOMElement $element
     * @return string
     */
    public static function detectLanguage(\DOMElement $element)
    {
        $class = $element->getAttribute('class');

        if (preg_match(self::$langTest, $class, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Get parent which has class name in form of "language-{name}"
     * @param  \DOMElement $element
     * @return \DOMNode
     */
    public static function &getParent(\DOMElement $element)
    {
        while ($element && preg_match(self::$langTest, $element->getAttribute('class')) !== 1) {
            $element = $element->parentNode;
        }
        return $element;
    }

    /**
     * Check if given element is 'pre'
     * @param  \DOMElement $element
     * @return boolean
     */
    public static function isPre (\DOMElement $element)
    {
        return preg_match("/pre/i", $element->nodeName) === 1;
    }

    /**
     * Checks if given array has the key.
     * If found returns the value else the set default value
     * @param  array   $arr
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public static function hasValue(array $arr, $key, $default = null)
    {
        return isset($arr[$key]) ? $arr[$key] : $default;
    }
}
