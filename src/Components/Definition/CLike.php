<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Definition for languages similar to 'C'
 * @package VKBansal\Spectrum\Definition\CLike
 * @version 0.4.2
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
                    'pattern' => '/(^|[^\\\\:])\\/\\/.+/',
                    'lookbehind' => true
                ]
            ],
            'string'=> '/("|\')(\\\\\n|\\\\?.)*?\g{1}/',
            'class-name'=> [
                "pattern" => "/((?:(?:class|interface|extends|implements|trait|instanceof|new)\\s+)|(?:catch\\s+\\())[a-z0-9_\\.\\\\]+/i",
                "lookbehind" => true,
                "inside" => [
                    "punctuation" => "/(\\.|\\\\)/"
                ]
            ],
            'keyword'=> "/\\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\\b/",
            'boolean' => "/\\b(true|false)\\b/",
            'function' => [
                "pattern" => "/[a-z0-9_]+\\(/i",
                "inside" => [
                    "punctuation" => "/\\(/"
                ]
            ],

            "number" => "/\\b-?(0x[\\dA-Fa-f]+|\\d*\\.?\\d+([Ee]-?\\d+)?)\\b/",
            "operator" => "/[-+]{1,2}|!|<=?|>=?|={1,3}|&{1,2}|\\|?\\||\\?|\\*|\\/|~|\\^|%/",
            "ignore" => "/&(lt|gt|amp);/i",
            'punctuation'=> "/[{}[\\];(),.:]/"
        ];
    }
}
