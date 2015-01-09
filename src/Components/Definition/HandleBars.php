<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractTemplateDefinition;

/**
 * Handlebars definition
 * @package VKBansal\Prism\Definition\Handlebars
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Handlebars extends AbstractTemplateDefinition
{
    /**
     * {@inheritdoc}
     */
    protected $delimiterRegex = "/\{\{\{[\w\W]+?\}\}\}|\{\{[\w\W]+?\}\}/";

    /**
     * {@inheritdoc}
     */
    protected $placeholderRegex = "/___HANDLEBARS([0-9]+)___/";

    /**
     * {@inheritdoc}
     */
    protected $placeholderStart = "___HANDLEBARS";

    /**
     * {@inheritdoc}
     */
    protected $placeholderEnd = "___";

    /**
     * {@inheritdoc}
     */
    protected $grammarName = "handlebars";

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'handlebars';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('markup', [
            'handlebars' => [
                "pattern" => $this->delimiterRegex,
                "inside" => [
                    'delimiter' => [
                        "pattern" => "/^\{\{\{?|\}\}\}?$/i",
                        "alias" => 'punctuation'
                    ],
                    'string' => "/([\"'])(\\\\?.)+?\g{1}/",
                    'number' => "/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/",
                    'boolean' => "/\b(true|false)\b/",
                    'block' => [
                        "pattern" => "/^(\s*~?\s*)[#\/]\w+/i",
                        "lookbehind" => true,
                        "alias" => 'keyword'
                    ],
                    'brackets' => [
                        "pattern" => "/\[[^\]]+\]/",
                        "inside" => [
                            "punctuation" => "/\[|\]/",
                            "variable" => "/[\w\W]+/"
                        ]
                    ],
                    'punctuation' => "/[!\"#%&'()*+,.\/;<=>@\[\\\\\]^`{|}~]/",
                    'variable' => "/[^!\"#%&'()*+,.\/;<=>@\[\\\\\]^`{|}~]+/"
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
        $this->insertBefore('handlebars', [
            'handlebars-comment' => [
                "pattern" => "/\{\{![\w\W]*?\}\}/",
                "alias" => ['handlebars', 'comment']
            ]
        ], 'tag');
    }
}
