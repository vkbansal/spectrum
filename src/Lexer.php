<?php
namespace VKBansal\Spectrum;

/**
 * Token Factory Class
 * @package VKBansal\Spectrum\Lexer
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Lexer
{
    /**
     * @var string|array<Token|string>
     */
    private $text;

    /**
     * @var array
     */
    private $grammar;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array<Token|string>
     */
    private $tokens = [];

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
    public function tokenize()
    {
        $strarr = [$this->text];

        foreach ($this->grammar as $token => $regex) {
            $this->patternWalk($strarr, $token, $regex);
        }
        return $this->tokens = $strarr;
    }

    /**
     * Walk over patterns for lexing
     * @param  array       &$strarr
     * @param  string      $token
     * @param  strin|array $regex
     */
    private function patternWalk(array &$strarr, $token, $regex)
    {
        $patterns = is_string($regex) || Util::isAssoc($regex) ? [$regex] : $regex;
        foreach ($patterns as $pattern) {
            $this->lex($strarr, $pattern, $token);
        }
    }

    /**
     * Converts Tokens to DOMElements
     * @param  \VKBansal\Spectrum\Spectrum $prism
     * @return array<\DOMElement|\DOMText>
     */
    public function toNodes(Spectrum $prism)
    {
        return array_map(function($token) use ($prism){
            if ($token instanceof Token) {
                return $token->toNode($prism);
            }
            return $prism->getDocument()->createTextNode($token);
        },$this->tokens);
    }

    /**
     * Optimize Regex in grammar
     * @param  array $grammar
     * @return array
     */
    private function optimizeGrammar($grammar)
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
     * @param  array        &$strarr
     * @param  string|array $pattern
     * @param  string       $token
     * @return void
     */
    private function lex(array &$strarr, $pattern, $token)
    {
        $count = count($strarr);

        for ($i = 0; $i < $count; $i++) {
            $str = $strarr[$i];

            if (count($strarr) > strlen($this->text)) {
                throw new LexerException("Something went terribly wrong with generator, aborting!");
            }

            if ($str instanceof Token) {
                continue;
            }

            $matches = $this->matchPatterns($pattern, $str);

            if (!$matches) {
                continue;
            }

            $args = $this->parseMatches($matches, $pattern, $token);

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
    private function resolvePattern($pattern)
    {
        if (is_string($pattern)) {
            return [$pattern, false, false, null];
        }

        $alias = Util::hasValue($pattern, 'alias');
        $inside = Util::hasValue($pattern, 'inside', false);
        $lookbehind = !!Util::hasValue($pattern, 'lookbehind', false);
        $pattern = $pattern['pattern'];

        return [$pattern, $lookbehind, $inside, $alias];
    }


    /**
     * Match Patterns
     * @param  array|string  $patterns
     * @param  string        $str
     * @return array|boolean
     */
    private function matchPatterns($patterns, $str)
    {
        list($pattern, $lookbehind) =  $this->resolvePattern($patterns);

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
        $upto = $from + strlen($match);

        $before = substr($str, 0, $from);
        $after = substr($str, $upto);

        return [$match, $before, $after];
    }

    /**
     * Parse Matches
     * @param  array        $matches
     * @param  array|string $patterns
     * @param  string       $token
     * @return array
     */
    private function parseMatches(array $matches, $patterns, $token)
    {
        list($match, $before, $after) = $matches;
        list($inside, $alias) =  array_slice($this->resolvePattern($patterns), 2);

        $args = [];

        if ($before) {
            $args[] = $before;
        }

        if ($inside) {
            $factory = new self($match, $inside, $this->language);
            $content = $factory->tokenize();
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
