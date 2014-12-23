<?php
namespace VKBansal\Prism\Tokens;

use VKBansal\Prism\Util;

/**
 * Token Generator Class
 * @package VKBansal\Prism\Tokens\Generator
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Generator
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $grammar;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var array<Token|string>
     */
    protected $tokens = [];

    /**
     * Constructor
     * @param string $text
     * @param array  $grammar
     * @param string $language
     */
    public function __construct($text, array $grammar, $language)
    {
        $this->text = $text;
        $this->grammar = $this->optimizeGrammar($grammar);
        $this->language = $language;
    }

    /**
     * Generates Tokens
     * @return array<Tokens|string>
     */
    public function generate()
    {
        $strarr = [$this->text];

        foreach ($this->grammar as $token => $regex) {
            $patterns = is_string($regex) || Util::isAssoc($regex) ? [$regex] : $regex;

            foreach ($patterns as $pattern) {

                $resolvedPattern = $this->resolvePattern($pattern); 

                //Don't cache the array length as it keeps changing
                for ($i = 0; $i < count($strarr); $i++) {
                    $str = $strarr[$i];

                    //If #Tokens > text length, something went terribly wrong
                    if (count($strarr) > strlen($this->text)) {
                        break 3;
                    }

                    if ($str instanceof Token) {
                        continue;
                    }

                    $args = $this->matchPatterns($token, $resolvedPattern, $str);

                    if ($args !== false) {
                        array_splice($strarr, $i, 1, $args);
                    }
                }
            }
        }
        return $this->tokens = $strarr;
    }

    /**
     * Converts Tokens to DOMElements
     * @param  \DOMDocument $parent
     * @return array<\DOMElement|\DOMText>
     */
    public function toNodes(\DOMDocument $parent)
    {
        $temp = [];

        foreach ($this->tokens as $token) {
            if ($token instanceof Token) {
                $temp[] = $token->toNode($parent);
            } else {
                $temp[] = $parent->createTextNode($token);
            }
        }
        return $temp;
    }

    /**
     * Optimize Regex in grammar
     * @param  array $grammar
     * @return array
     */
    protected function optimizeGrammar($grammar)
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
    protected function resolvePattern($pattern)
    {
        if (is_string($pattern)) {
            return [$pattern, false, false, null];
        }
        $alias = isset($pattern['alias']) ? $pattern['alias'] : null;

        $inside = isset($pattern['inside']) ? $pattern['inside'] : false;

        $lookbehind = isset($pattern['lookbehind']) ? !!$pattern['lookbehind'] : false;
        
        $pattern = $pattern['pattern'];

        return [$pattern, $lookbehind, $inside, $alias];
    }

    /**
     * Match Patterns
     * @param  string $token
     * @param  array  $resolvedPattern
     * @param  string $str
     * @return array<Token|string>
     */
    protected function matchPatterns($token, $resolvedPattern, $str)
    {
        list($pattern, $lookbehind, $inside, $alias) = $resolvedPattern;

        $lookbehindLength = 0;

        $index = preg_match($pattern, $str, $matches, PREG_OFFSET_CAPTURE);

        if ($index === false || $index === 0) {
            return false;
        }
                            
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

        if ($inside !== false) {
            $generator = new Generator($match, $inside, $this->language);
            $content = $generator->generate();
        } else {
            $content = $match;
        }
        
        $wrapped = new Token($token, $content, $this->language, $alias);
        
        $args[] = $wrapped;

        if ($after !== false && $after !== "") {
            $args[] = $after;
        }
        return $args;
    }
}
