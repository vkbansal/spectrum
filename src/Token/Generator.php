<?php
namespace VKBansal\Prism\Token;

use VKBansal\Prism\Prism;
use VKBansal\Prism\Util;

/**
 * Token Generator Class
 * @package VKBansal\Prism\Token\Generator
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Generator
{
    /**
     * @var string|array<Token|string>
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
     * @return array<Token|string>
     */
    public function generate()
    {
        $strarr = [$this->text];

        foreach ($this->grammar as $token => $regex) {

            $patterns = is_string($regex) || Util::isAssoc($regex) ? [$regex] : $regex;

            foreach ($patterns as $pattern) {
                $this->tokenize($strarr, $pattern, $token);
            }
        }
        return $this->tokens = $strarr;
    }

    /**
     * Converts Tokens to DOMElements
     * @param  \DOMDocument $parent
     * @return array<\DOMElement|\DOMText>
     */
    public function toNodes(Prism $prism)
    {
        $temp = [];

        foreach ($this->tokens as $token) {
            if ($token instanceof Token) {
                $temp[] = $token->toNode($prism);
            } else {
                $temp[] = $prism->getDocument()->createTextNode($token);
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
     * Convert matching patterns to tokens
     * @param  array        &$strarr [description]
     * @param  string|array $pattern [description]
     * @param  string       $token   [description]
     * @return void
     */
    protected function tokenize(&$strarr, $pattern, $token)
    {
        $resolvedPattern = $this->resolvePattern($pattern);

        $count = count($strarr);

        for ($i = 0; $i < $count; $i++) {
            $str = $strarr[$i];

            if (count($strarr) > strlen($this->text)) {
                throw new GeneratorException("Something went teribbly wrong with generator, aborting!");
            }

            if ($str instanceof Token) {
                continue;
            }

            $args = $this->matchPatterns($token, $resolvedPattern, $str);

            if ($args) {
                array_splice($strarr, $i, 1, $args);
                $count = count($strarr);
            }
        }
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

        if (!$index) {
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
        
        if ($before) {
            $args[] = $before;
        }

        if ($inside) {
            $generator = new Generator($match, $inside, $this->language);
            $content = $generator->generate();
        } else {
            $content = $match;
        }
        
        $wrapped = new Token($token, $content, $this->language, $alias);
        
        $args[] = $wrapped;

        if ($after) {
            $args[] = $after;
        }
        return $args;
    }
}
