<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * SmallTalk definition
 * @package VKBansal\Spectrum\Definition\SmallTalk
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class SmallTalk extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'smalltalk';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            "comment" => "/\"(?:\"\"|[^\"])+\"/",
            "string" => "/'(?:''|[^'])+'/",
            "symbol" => "/#[\\da-z]+|#(?:-|([+\\/\\\\*~<>=@%|&?!])\\g{1}?)|#(?=\\()/i",
            "block-arguments" => [
                "pattern" => "/(\\[\\s*)(?=:)[^\\[|]+?\\|/",
                "lookbehind" => true,
                "inside" => [
                    "variable" => "/:[\\da-z]+/i",
                    "punctuation" => "/\\|/"
                ]
            ],
            "temporary-variables" => [
                "pattern" => "/\\|[^|]+\\|/",
                "inside" => [
                    "variable" => "/[\\da-z]+/i",
                    "punctuation" => "/\\|/"
                ]
            ],
            "keyword" => "/\\b(?:nil|true|false|self|super|new)\\b/",
            "character" => [
                "pattern" => "/\\$./",
                "alias" => 'string'
            ],
            "number" => [
                "/\\d+r-?[\\dA-Z]+(?:\\.[\\dA-Z]+)?(?:e-?\\d+)?/",
                "/(?:\\B-|\\b)\\d+(?:\\.\\d+)?(?:e-?\\d+)?/"
            ],
            "operator" => "/[:=~<>]=|~~|\\/\\/|\\\\\\\\|>>|[!^=<>+\\-*\\/&|,@]/",
            "punctuation" => "/[.;:?\\[\\](){}]/"
        ];
    }
}
