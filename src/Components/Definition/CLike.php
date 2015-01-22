<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Definition for languages similat to 'C'
 * @package VKBansal\Prism\Definition\CLike
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class CLike extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'clike';

    /**
     * {@inheritdoc}
     */
    protected static $default = true;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => [
                [
                    'pattern' => '/(^|[^\\\\])\/\*[\w\W]*?\*\//',
                    'lookbehind' => true
                ],
                [
                    'pattern' => '/(^|[^\\\\:])\/\/.*?(\r?\n|$)/',
                    'lookbehind' => true
                ]
            ],
            'string'=> '/("|\')(\\\\\n|\\\\?.)*?\g{1}/',
            'class-name'=> [
                "pattern" => "/((?:(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\\\]+/i",
                "lookbehind" => true,
                "inside" => [
                    "punctuation" => "/(\.|\\\\)/"
                ]
            ],
            'keyword'=> "/\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/",
            'boolean' => "/\b(true|false)\b/",
            'function' => [
                "pattern" => "/[a-z0-9_]+\(/i",
                "inside" => [
                    "punctuation" => "/\(/"
                ]
            ],

            "number" => "/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/",
            "operator" => "/[-+]{1,2}|!|<=?|>=?|={1,3}|&{1,2}|\|?\||\?|\*|\/|~|\^|%/",
            "ignore" => "/&(lt|gt|amp);/i",
            'punctuation'=> "/[{}[\];(),.:]/"
        ];
    }
}
