<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Nasm definition
 * @package VKBansal\Prism\Definition\Nasm
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Nasm extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nasm';
    }

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
            'number' => "/(\b|-|(?=\\$))(0[hHxX][\dA-Fa-f]*\.?[\dA-Fa-f]+([pP][+-]?\d+)?|\d[\dA-Fa-f]+[hHxX]|\\$\d[\dA-Fa-f]*|0[oOqQ][0-7]+|[0-7]+[oOqQ]|0[bByY][01]+|[01]+[bByY]|0[dDtT]\d+|\d+[dDtT]?|\d*\.?\d+([Ee][+-]?\d+)?)\b/",
            'operator' => "/[\[\]\*+\-\/%<>=&|\\$!]/m"
        ];
    }
}
