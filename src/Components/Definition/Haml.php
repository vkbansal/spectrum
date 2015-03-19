<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Haml definition
 * @package VKBansal\Spectrum\Definition\Ruby
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Haml extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'haml';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['ruby', 'markup', 'css', 'javascript'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        /*
         * remaining: Handle multiline code after tag
         * %foo= some |
         *       multiline |
         *       code |
         */
        return [
            'multiline-comment' => [ // Multiline stuff should appear before the rest
                [
                    'pattern' => "/((?:^|\\n)([\\t ]*))\/.*(\\n\g{2}[\\t ]+.+)*/",
                    "lookbehind" => true,
                    "alias" => 'comment'
                ],
                [
                    "pattern" => "/((?:^|\\n)([\\t ]*))-#.*(\\n\g{2}[\\t ]+.+)*/",
                    "lookbehind" => true,
                    "alias" => 'comment'
                ]
            ],
            'multiline-code' => [
                [
                    "pattern" => "/((?:^|\\n)([\\t ]*)(?:[~-]|[&!]?=)).*,[\\t ]*(\\n\g{2}[\\t ]+.*,[\\t ]*)*(\\n\g{2}[\\t ]+.+)/",
                    "lookbehind" => true,
                    "inside" => [ "rest" => $this->getDefinition('ruby', []) ]
                ],
                [
                    "pattern" => "/((?:^|\\n)([\\t ]*)(?:[~-]|[&!]?=)).*\|[\\t ]*(\\n\g{2}[\\t ]+.*\|[\\t ]*)*/",
                    "lookbehind" => true,
                    "inside" => [ "rest" => $this->getDefinition('ruby', []) ]
                ]
            ],
            'filter' => [ // See at the end of the file for known filters
                "pattern" => "/((?:^|\\n)([\\t ]*)):[\w-]+(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/",
                "lookbehind" => true,
                "inside" => [
                    'filter-name' => [ "pattern" => "/^:[\w-]+/", "alias" => "variable" ]
                ]
            ],
            'markup' => [
                "pattern" => "/((?:^|\\n)[\\t ]*)<.+/",
                "lookbehind" => true,
                "inside" => [ "rest" => $this->getDefinition('markup', []) ]
            ],
            'doctype' => [ "pattern" => "/((?:^|\\n)[\\t ]*)!!!(?: .+)?/", "lookbehind" => true ],
            'tag' => [ // Allows for one nested group of braces
                "pattern" => "/((?:^|\\n)[\\t ]*)[%.#][\w\-#.]*[\w\-](?:\([^)]+\)|\{(?:\{[^}]+\}|[^}])+\}|\[[^\]]+\])*[\/<>]*/",
                "lookbehind" => true,
                "inside" => [
                    'attributes' => [
                        [   // Lookbehind tries to prevent interpolations for breaking it all
                            // Allows for one nested group of braces
                            "pattern" => "/(^|[^#])\{(?:\{[^}]+\}|[^}])+\}/",
                            "lookbehind" => true,
                            "inside" => [ "rest" => $this->getDefinition('ruby', []) ]
                        ],
                        [
                            "pattern" => "/\([^)]+\)/",
                            "inside" => [
                                'attr-value' => [
                                    "pattern" => "/(=\s*)(?:\"(?:\\\\?.)*?\"|[^)\s]+)/",
                                    "lookbehind" => true
                                ],
                                'attr-name' => "/[\w:-]+(?=\s*!?=|\s*[,)])/",
                                'punctuation' => "/[=(),]/"
                            ]
                        ],
                        [
                            "pattern" => "/\[[^\]]+\]/",
                            "inside" => [ "rest" => $this->getDefinition('ruby', []) ]
                        ]
                    ],
                    'punctuation' => "/[<>]/"
                ]
            ],
            'code' => [
                "pattern" => "/((?:^|\\n)[\\t ]*(?:[~-]|[&!]?=)).+/",
                "lookbehind" => true,
                "inside" => [ "rest" => $this->getDefinition('ruby', []) ]
            ],
            'interpolation' => [ // Interpolations in plain text
                "pattern" => "/#\{[^}]+\}/",
                "inside" => [
                    'delimiter' => [ "pattern" => "/^#\{|\}$/", "alias" => 'punctuation' ],
                    "rest" => $this->getDefinition('ruby', [])
                ]
            ],
            'punctuation' => [ "pattern" => "/((?:^|\\n)[\\t ]*)[~=\-&!]/", "lookbehind" => true ]
        ];
    }

    public function setup()
    {
        $filter_pattern = "/((?:^|\\n)([\\t ]*)):{{filter_name}}(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/";

        // Non exhaustive list of available filters and associated languages
        $filters = [
            'css',
            [
                "filter" => 'coffee',
                "language" => 'coffeescript'
            ],
            'erb',
            'javascript',
            'less',
            'markdown',
            'ruby',
            'scss',
            'textile'
        ];
        $all_filters = [];

        for ($i = 0, $l = count($filters); $i < $l; $i++) {

            $filter = $filters[$i];
            $filter = is_string($filter) ? [ "filter" => $filter, "language"=> $filter] : $filter;

            if ($this->hasDefinition($filter['language'])) {

                $all_filters['filter-' . $filter['filter']] = [
                    "pattern" => str_replace('{{filter_name}}', $filter['filter'], $filter_pattern),
                    "lookbehind" => true,
                    "inside" => [
                        'filter-name'=> [
                            "pattern" => "/^:[\w-]+/",
                            "alias" => 'variable'
                        ],
                        "rest"=> $this->getDefinition($filter['language'], [])
                    ]
                ];
            }
        }

        $this->insertBefore('haml', $all_filters, 'filter');
    }
}
