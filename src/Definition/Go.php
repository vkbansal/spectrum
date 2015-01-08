<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Go definition
 * @package VKBansal\Prism\Definition\Go
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Go extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'go';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'keyword' => "/\b(break|case|chan|const|continue|default|defer|else|fallthrough|for|func|go(to)?|if|import|interface|map|package|range|return|select|struct|switch|type|var)\b/",
            'builtin' => "/\b(bool|byte|complex(64|128)|error|float(32|64)|rune|string|u?int(8|16|32|64|)|uintptr|append|cap|close|complex|copy|delete|imag|len|make|new|panic|print(ln)?|real|recover)\b/",
            'boolean' => "/\b(_|iota|nil|true|false)\b/",
            'operator' => "/([(){}\[\]]|[*\/%^!]=?|\+[=+]?|-[>=-]?|\|[=|]?|>[=>]?|<(<|[=-])?|==?|&(&|=|^=?)?|\.(\.\.)?|[,;]|:=?)/",
            'number' => "/\b(-?(0x[a-f\d]+|(\d+\.?\d*|\.\d+)(e[-+]?\d+)?)i?)\b/i",
            'string' => "/(\"|'|`)(\\\\?.|\\r|\\n)*?\g{1}/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $go =& $this->getDefinition('go');
        unset($go['class-name']);
    }
}
