<?php
namespace VKBansal\Prism\Languages\Definitions;

use VKBansal\Prism\Languages\AbstractLanguage;

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
