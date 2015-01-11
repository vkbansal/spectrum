<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractTemplateDefinition;

/**
 * Smarty definition
 * @package VKBansal\Prism\Definition\Smarty
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Smarty extends AbstractTemplateDefinition
{
    /**
     * {@inheritdoc}
     */
    protected $delimiterRegex = "/\{\*[\w\W]+?\*\}|\{[\w\W]+?\}/";

    /**
     * {@inheritdoc}
     */
    protected $placeholderRegex = "/___SMARTY([0-9]+)___/";

    /**
     * {@inheritdoc}
     */
    protected $placeholderStart = "___SMARTY";

    /**
     * {@inheritdoc}
     */
    protected $placeholderEnd = "___";

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'smarty';
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
        return $this->extend('markup', [
            'smarty' => [
                'pattern' => $this->delimiterRegex,
                'inside' => [
                    'delimiter' => [
                        'pattern' => "/^\{|\}$/i",
                        'alias' => 'punctuation'
                    ],
                    'string' => "/([\"'])(\\\\?.)*?\g{1}/",
                    'number' => "/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/",
                    'variable' => [
                        "/\\$(?!\d)\w+/",
                        "/#(?!\d)\w+#/",
                        [
                            'pattern' => "/(\.|->)(?!\d)\w+/",
                            'lookbehind' => true
                        ],
                        [
                            'pattern' => "/(\[)(?!\d)\w+(?=\])/",
                            'lookbehind' => true
                        ]
                    ],
                    'function' => [
                        [
                            'pattern' => "/(\|\s*)@?(?!\d)\w+/",
                            'lookbehind' => true
                        ],
                        "/^\/?(?!\d)\w+/",
                        "/(?!\d)\w+(?=\()/"
                    ],
                    'attr-name' => [
                        // Value is made optional because it may have already been tokenized
                        'pattern' => "/\w+\s*=\s*(?:(?!\d)\w+)?/",
                        'inside' => [
                            "variable" => [
                                'pattern' => "/(=\s*)(?!\d)\w+/",
                                'lookbehind' => true
                            ],
                            "punctuation" => "/=/"
                        ]
                    ],
                    'punctuation' => "/[\[\]().,=\|:`]|\->/",
                    'operator' => [
                        "/[+\-*\/%]|===?|[!<>]=?|&&|\|\|/",
                        "/\bis\s+(?:not\s+)?(?:div|even|odd)(?:\s+by)?\b/",
                        "/\b(?:eq|neq?|gt|lt|gt?e|lt?e|not|mod|or|and)\b/"
                    ],
                    'keyword' => "/\b(?:false|off|on|no|true|yes)\b/"
                ]
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function templateSetup()
    {
        // Comments are inserted at top so that they can
        // surround markup
        $this->insertBefore('smarty', [
            'smarty-comment' => [
                "pattern" => "/\{\*[\w\W]*?\*\}/",
                "alias" => ['smarty', 'comment']
            ]
        ], 'tag');
    }
}
