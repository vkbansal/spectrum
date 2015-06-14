<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Rip definition
 * @package VKBansal\Spectrum\Definition\Rip
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Rip extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'rip';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/#[^\\r\\n]*(\\r?\\n|$)/",
            'keyword' => "/(?:=>|->)|\\b(?:class|if|else|switch|case|return|exit|try|catch|finally|raise)\\b/",
            'builtin' => "/\\b(@|System)\\b/",
            'boolean' => "/\\b(true|false)\\b/",
            'date' => "/\\b\\d{4}-\\d{2}-\\d{2}\\b/",
            'time' => "/\\b\\d{2}:\\d{2}:\\d{2}\\b/",
            'datetime' => "/\\b\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}\\b/",
            'number' => "/[+-]?(?:(?:\\d+\\.\\d+)|(?:\\d+))/",
            'character' => "/\\B`[^\\s`'\",.:;#\\/\\\\()<>\\[\\]{}]\\b/",
            'regex' => [
                'pattern' => "/(^|[^\\/])\\/(?!\\/)(\\[.+?]|\\\\.|[^\\/\\r\\n])+\\/(?=\\s*($|[\\r\\n,.;})]))/",
                'lookbehind' => true
            ],
            'symbol' => "/:[^\\d\\s`'\",.:;#\\/\\\\()<>\\[\\]{}][^\\s`'\",.:;#\\/\\\\()<>\\[\\]{}]*/",
            'string' => "/(\"|')(\\\\?.)*?\\g{1}/",
            'punctuation' => "/(?:\\.{2,3})|[`,.:;=\\/\\\\()<>\\[\\]{}]/",
            'reference' => "/[^\\d\\s`'\",.:;#\\/\\\\()<>\\[\\]{}][^\\s`'\",.:;#\\/\\\\()<>\\[\\]{}]*/"
        ];
    }
}
