<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * R definition
 * @package VKBansal\Prism\Definition\Rlang
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Rlang extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'r';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/#.+/",
            'string' => "/(['\"])(?:\\\\?.)*?\g{1}/",
            'percent-operator' => [
                // Includes user-defined operators
                // and %%, %*%, %/%, %in%, %o%, %x%
                'pattern' => "/%[^%]*?%/",
                'alias' => 'operator'
            ],
            'boolean' => "/\b(?:TRUE|FALSE)\b/",
            'ellipsis' => "/\.\.(?:\.|\d+)/",
            'number' => [
                "/\b(?:NaN|Inf)\b/",
                "/\b(?:0x[\dA-Fa-f]+(?:\.\d*)?|\d*\.?\d+)(?:[EePp][+-]??\d+)?[iL]?\b/"
            ],
            'keyword' => "/\b(?:if|else|repeat|while|function|for|in|next|break|NULL|NA|NA_integer_|NA_real_|NA_complex_|NA_character_)\b/",
            'operator' => "/->>?|<?<-|[<>!=]=?|::?|&&?|\|\|?|[+\-*\/^$@~]/",
            'punctuation' => "/[(){}\[\],;]/"
        ];
    }
}
