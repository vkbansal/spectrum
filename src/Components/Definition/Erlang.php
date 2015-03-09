<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Erlang definition
 * @package VKBansal\Spectrum\Definition\Erlang
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Erlang extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'erlang';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/%.+/",
            'string' => "/\"(?:\\\\?.)*?\"/",
            'quoted-function' => [
                "pattern" => "/'[^']+'(?=\()/",
                "alias" => 'function'
            ],
            'quoted-atom' => [
                "pattern" => "/'[^']+'/",
                "alias" => 'atom'
            ],
            'boolean' => "/\b(?:true|false)\b/",
            'keyword' => "/\b(?:fun|when|case|of|end|if|receive|after|try|catch)\b/",
            'number' => [
                "/\\\$\\\\?./",
                "/\d+#[a-z0-9]+/i",
                "/(?:\b|-)\d*\.?\d+([Ee][+-]?\d+)?\b/"
            ],
            'function' => "/\b[a-z][\w@]*(?=\()/",
            'variable' => "/(?:\b|\?)[A-Z_][\w@]*/",
            'operator' => [
                "/[=\/>:]=|>=|=[:\/]=|\+\+?|--?|[=*\/!]|\b(?:bnot|div|rem|band|bor|bxor|bsl|bsr|not|and|or|xor|orelse|andalso)\b/",
                [
                    "pattern" => "/(^|(?!<).)<(?!<)/",
                    "lookbehind" => true
                ],
                [
                    "pattern" => "/(^|(?!>).)>(?!>)/",
                    "lookbehind" => true
                ]
            ],
            'atom' => "/\b[a-z][\w@]*/",
            'punctuation' => "/[()[\]{}:;,.#|]|<<|>>/"
        ];
    }
}
