<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Scheme definition
 * @package VKBansal\Spectrum\Definition\Ruby
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Scheme extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'scheme';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'boolean' => "/#(t|f){1}/",
            'comment' => "/;.*/",
            'keyword' => [
                'pattern' => "/([(])(define(-syntax|-library|-values)?|(case-)?lambda|let(-values|(rec)?(\\*)?)?|else|if|cond|begin|delay|delay-force|parameterize|guard|set!|(quasi-)?quote|syntax-rules)/",
                'lookbehind' => true
            ],
            'builtin' => [
                'pattern' =>  "/([(])(cons|car|cdr|null\\?|pair\\?|boolean\\?|eof-object\\?|char\\?|procedure\\?|number\\?|port\\?|string\\?|vector\\?|symbol\\?|bytevector\\?|list|call-with-current-continuation|call\\/cc|append|abs|apply|eval)\\b/",
                'lookbehind' => true
            ],
            'string' =>  "/([\"])(?:(?=(\\\\?))\\g{2}.)*?\\g{1}|'[^('|\\s)]+/", //thanks http://stackoverflow.com/questions/171480/regex-grabbing-values-between-quotation-marks
            'number' => "/(\\s|\\))[-+]?[0-9]*\\.?[0-9]+((\\s*)[-+]{1}(\\s*)[0-9]*\\.?[0-9]+i)?/",
            'operator' => "/(\\*|\\+|\\-|%|\\/|<=|=>|>=|<|=|>)/",
            'function' => [
                'pattern' => "/([(])[^(\\s|\\))]*\\s/",
                'lookbehind' => true
            ],
            'punctuation' => "/[()]/"
        ];
    }
}
