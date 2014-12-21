<?php
namespace VKBansal\Prism\Languages\Definitions;

use VKBansal\Prism\Languages\AbstractLanguage;

class CLike extends AbstractLanguage
{
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
            'string'=> '/("|\')(\\\\?.)*?\g{1}/',
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
            "operator" => "/[-+]{1,2}|!|<=?|>=?|={1,3}|&{1,2}|\|?\||\?|\*|\/|\~|\^|\%/",
            "ignore" => "/&(lt|gt|amp);/",
            'punctuation'=> "/[{}\[\];\(\),.:]/"
        ];
    }
}
