<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Definition\AbstractLanguage;

class Ini extends AbstractLanguage
{
    public function definition()
    {
        return [
            'comment' => "/^\s*;.*$/",
            'important' => "/\[.*?\]/m",
            'constant'=> "/^\s*[^\s\=]+?(?=[ \t]*\=)/m",
            'attr-value'=> [
                "pattern" => "/\=.*/m",
                "inside" => [
                    'punctuation'=> "/^[\=]/"
                ]
            ]
        ];
    }
}
