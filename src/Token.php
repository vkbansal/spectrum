<?php
namespace VKBansal\Prism;

use DOMDocument;
use VKBansal\Prism\Node;
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

    /**
     * Constructor
     * @param string             $type
     * @param string|array|Token $content
     * @param null|string        $alias
     */
    public function __construct($type, $content, $alias = null)
    {
        $this->type = $type;
        $this->content = $content;
        $this->alias = $alias;
    }

    /**
     * Detokenize
     * @param  string|array|Token $content
     * @param  string             $language
     * @param  null|string|array  $parent
     * @return DOMElement|DOMText|array<DOMElement|DOMText>
     */
    public static function detokenize($content, $language, $parent = null)
    {
        $document = new DOMDocument();
        
        if (is_string($content)) {
            return $document->createTextNode($content);
        }

        if (is_array($content)) {
            $temp = [];
            $count = count($content);
            for ($i = 0; $i < $count; $i++) {
                if (!$content[$i]) {
                    continue;
                }

                $temp[] = self::detokenize($content[$i], $language, $content);
            }

            return $temp;
        }

        $span = new Node($content, $language, $parent);

        return $span->getDOMNode();
    }

    /**
     * Tokenize
     * @param string      $text
     * @param array       $grammar
     * @return Token[]
     */
    public static function tokenize($text, $grammar)
    {
        $strarr = [Util::decodeHTML($text)];

        $grammar = self::optimizeRegex($grammar);

        foreach ($grammar as $token => $regex) {
            $patterns = is_string($regex) || Util::isAssoc($regex) ? [$regex] : $regex;

            foreach ($patterns as $pattern) {

                $lookbehindLength = 0;

                list($pattern, $lookbehind, $inside, $alias) = self::resolvePattern($pattern);

                //Don't cache the array length as it keeps changing
                for ($i = 0; $i < count($strarr); $i++) {
                    $str = $strarr[$i];

                    //If #Tokens > text length, something went terribly wrong
                    if (count($strarr) > strlen($text)) {
                        break 3;
                    }

                    if ($str instanceof Token) {
                        continue;
                    }

                    $index = preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE);

                    if ($index > 0) {
                            
                        if ($lookbehind) {
                            $lookbehindLength = strlen($matches[1][0]);
                        }

                        $matches = array_slice($matches, 0, 1);
                        $from = $matches[0][1] + $lookbehindLength;
                        $match = substr($matches[0][0], $lookbehindLength);
                        $to = $from + strlen($match);

                        $before = substr($str, 0, $from);
                        $after = substr($str, $to);
                        
                        $args = [];
                        
                        if ($before !== false && $before !== "") {
                            $args[] = $before;
                        }

                        $content = $inside ? self::Tokenize($match, $inside) : $match;

                        $wrapped = new Token($token, $content, $alias);
                        
                        $args[] = $wrapped;

                        if ($after !== false && $after !== "") {
                            $args[] = $after;
                        }
                        
                        array_splice($strarr, $i, 1, $args);
                    }
                }
            }
        }
        return $strarr;
    }

    /**
     * Optimize Regex in grammar
     * @param  array $grammar
     * @return array
     */
    protected static function optimizeRegex($grammar)
    {
        $rest = isset($grammar['rest']) ? $grammar['rest'] : [];

        foreach ($rest as $key => $value) {
            $grammar[$key] = $value;
        }

        unset($grammar['rest']);

        return $grammar;
    }

    /**
     * Resolves given Pattern to find out pattern, lookbehind, inside and alias
     * @param  array|string $pattern
     * @return array
     */
    protected static function resolvePattern($pattern)
    {
        if (is_string($pattern)){
            return [$pattern, false, false, null];
        }

        $inside = isset($pattern['inside']) ? $pattern['inside'] : false;

        $alias = isset($pattern['alias']) ? $pattern['alias'] : null;

        $lookbehind = isset($pattern['lookbehind']) ? !!$pattern['lookbehind'] : false;
        
        $pattern = $pattern['pattern'];

        return [$pattern, $lookbehind, $inside, $alias];
    }
}
