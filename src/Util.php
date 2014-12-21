<?php
namespace VKBansal\Prism;

/**
 * Utility Class
 * @package VKBansal\Prism\Languages\Repository
 * @version 0.1.0
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
}
