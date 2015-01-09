<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * INI script definition
 * @package VKBansal\Prism\Definition\Ini
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Ini extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ini';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/^\s*;.*$/m",
            'important' => "/\[.*?\]/m",
            'constant'=> "/^\s*[^\s\=]+?(?=[ \\t]*\=)/m",
            'attr-value'=> [
                "pattern" => "/\=.*/m",
                "inside" => [
                    'punctuation'=> "/^[\=]/"
                ]
            ]
        ];
    }
}
