<?php
namespace VKBansal\Prism\Definition;

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
