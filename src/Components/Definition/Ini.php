<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * INI script definition
 * @package VKBansal\Spectrum\Definition\Ini
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Ini extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'ini';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/^\s*;.*$/m",
            'important' => "/\[.*?\]/m",
            'constant'=> "/^\s*[^\s=]+?(?=[ \\t]*=)/m",
            'attr-value'=> [
                "pattern" => "/=.*/m",
                "inside" => [
                    'punctuation'=> "/^[=]/"
                ]
            ]
        ];
    }
}
