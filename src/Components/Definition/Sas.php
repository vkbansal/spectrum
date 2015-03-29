<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * SAS definition
 * @package VKBansal\Spectrum\Definition\Sas
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Sas extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'sas';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            "datalines" => [
                "pattern" => "/(^|[\\r\\n])\\s*(?:(?:data)?lines|cards);[\\s\\S]+?[\\r\\n];/i",
                "lookbehind" => true,
                "inside" => [
                    "keyword" => [
                        "pattern" => "/^(\\s*)(?:(?:data)?lines|cards)/i",
                        "lookbehind" => true
                    ],
                    "punctuation" => "/;/",
                    "data" => [
                        "pattern" => "/[\\s\\S]+/",
                        "alias" => 'string'
                    ]
                ]
            ],
            "comment" => [
                [
                    "pattern" => "/(^\\s*|;\\s*)\\*.*;/m",
                    "lookbehind" => true
                ],
                "/\\/\\*[\\s\\S]+?\\*\\//"
            ],
            "datetime" => [
                // '1jan2013'd, '9:25:19pm't, '18jan2003:9:27:05am'dt
                "pattern" => "/'[^']+'(?:d|d?t)\\b/i",
                "alias" => 'number'
            ],
            "string" => "/([\"'])(?:\\g{1}\\g{1}|(?!\\g{1})[\\s\\S])*\\g{1}/",
            "keyword" => "/\\b(?:data|else|format|if|input|proc|run|then)\\b/i",
            // Decimal (1.2e23), hexadecimal (0c1x)
            "number" => "/(?:\\B-|\\b)(?:[\\da-f]+x|\\d+(?:\\.\\d+)?(?:e[+-]?\\d+)?)/i",
            "operator" => "/\\*\\*|\\|\\||!!|¦¦|<>|><|[~¬^<>]?=|[*\\/+\\-<>&\\|!¦~¬^]|\\b(?:eq|ne|gt|lt|ge|le|in|not)\\b/i",
            "punctuation" => "/[$%@.(){}\\[\\];,\\\\]/"
        ];
    }
}
