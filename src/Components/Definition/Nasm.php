<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Nasm definition
 * @package VKBansal\Spectrum\Definition\Nasm
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Nasm extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'nasm';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/;.*$/m",
            'string' => "/(\"|'|`)(\\\\?.)*?\g{1}/m",
            'label' => [
                'pattern' => "/^\s*[A-Za-z\._\?\\$][\w\.\?\\$@~#]*:/m",
                'alias' => 'function'
            ],
            'keyword' => [
                "/\[?BITS (16|32|64)\]?/m",
                "/^\s*section\s*[a-zA-Z\.]+:?/im",
                "/(?:extern|global)[^;]*/im",
                "/(?:CPU|FLOAT|DEFAULT).*$/m",
            ],
            'register' => [
                'pattern' => "/\b(?:st\d|[xyz]mm\d\d?|[cdt]r\d|r\d\d?[bwd]?|[er]?[abcd]x|[abcd][hl]|[er]?(bp|sp|si|di)|[cdefgs]s)\b/i",
                'alias' => 'variable'
            ],
            'number' => "/(\b|-|(?=\\$))(0[hx][\da-f]*\.?[\da-f]+(p[+-]?\d+)?|\d[\da-f]+[hx]|\\$\d[\da-f]*|0[oq][0-7]+|[0-7]+[oq]|0[by][01]+|[01]+[by]|0[dt]\d+|\d*\.?\d+(\.?e[+-]?\d+)?[dt]?)\b/i",
            'operator' => "/[\[\]\*+\-\/%<>=&|\\$!]/m"
        ];
    }
}
