<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Twig definition
 * @package VKBansal\Prism\Definition\Twig
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Twig extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twig';
    }

    /**
     * {@inheritdoc}
     */
    public function requires()
    {
        return ['markup'];
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/\{\#[\s\S]*?\#\}/",
            'tag' => [
                "pattern" => "/(\{\{[\s\S]*?\}\}|\{\%[\s\S]*?\%\})/",
                "inside" => [
                    'ld' => [
                        "pattern" => "/^(\{\{\-?|\{\%\-?\s*\w+)/",
                        "inside" => [
                            'punctuation' => "/^(\{\{|\{\%)\-?/",
                            'keyword' => "/\w+/"
                        ]
                    ],
                    'rd' => [
                        "pattern" => "/\-?(\%\}|\}\})$/",
                        "inside" => [
                            'punctuation' => "/.*/"
                        ]
                    ],
                    'string' => [
                        "pattern" => "/(\"|')(\\\\?.)*?\g{1}/",
                        "inside" => [
                            'punctuation' => "/^('|\")|('|\")$/"
                        ]
                    ],
                    'keyword' => "/\b(if)\b/",
                    'boolean' => "/\b(true|false|null)\b/",
                    'number' => "/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/",
                    'operator' => "/==|=|\!=|<|>|>=|<=|\+|\-|~|\*|\/|\/\/|%|\*\*|\|/",
                    'space-operator'=> [
                        "pattern" => "/(\s)(\b(not|b\-and|b\-xor|b\-or|and|or|in|matches|starts with|ends with|is)\b|\?|:|\?\:)(?=\s)/",
                        "lookbehind" => true,
                        "inside" => [
                            'operator' => "/.*/"
                        ]
                    ],
                    'property' => "/\b[a-zA-Z_][a-zA-Z0-9_]*\b/",
                    'punctuation' => "/\(|\)|\[\]|\[|\]|\{|\}|\:|\.|,/"
                ]
            ],
            // The rest can be parsed as HTML
            'other' => [
                "pattern" => "/[\s\S]*/",
                "inside" => $this->getDefinition('markup')
            ]
        ];
    }
}
