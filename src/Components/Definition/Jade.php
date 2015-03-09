<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Jade definition
 * @package VKBansal\Spectrum\Definition\Jade
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Jade extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'jade';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'multiline-comment' => [ // Multiline stuff should appear before the rest
                "pattern" => "/((?:^|\\n)([\\t ]*))\/\/.*(\\n\g{2}[\\t ]+.+)*/",
                "lookbehind" => true,
                "alias" => 'comment'
            ],
            // All the tag-related part is in lookbehind
            // so that it can be highlighted by the "tag" pattern
            'multiline-script' => [
                "pattern" => "/((?:^|\\n)([\\t ]*)script\b.*\.[\\t ]*)(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/",
                "lookbehind" => true,
                "inside" => [ "rest" => $this->getDefinition('javascript') ]
            ],
            'filter' => [ // See at the end of the file for known filters
                "pattern" => "/((?:^|\\n)([\\t ]*)):.+(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/",
                "lookbehind" => true,
                "inside" => [ 'filter-name' => [ "pattern" => "/^:[\w-]+/", "alias" => 'variable' ] ]
            ],
            'multiline-plain-text' => [
                "pattern" => "/((?:^|\\n)([\\t ]*)[\w\-#.]+\.[\\t ]*)(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/",
                "lookbehind" => true
            ],
            'markup' => [
                "pattern" => "/((?:^|\\n)[\\t ]*)<.+/",
                "lookbehind" => true,
                "inside" => [ "rest" => $this->getDefinition('markup') ]
            ],
            'comment' => [
                "pattern" => "/((?:^|\\n)[\\t ]*)\/\/.+/",
                "lookbehind" => true
            ],
            'doctype' => [ "pattern" => "/((?:^|\\n)[\\t ]*)doctype(?: .+)?/", "lookbehind" => true ],
            'flow-control' => [ // This handle all conditional and loop keywords
                "pattern" => "/((?:^|\\n)[\\t ]*)(?:if|unless|else|case|when|default|each|while)(?: .+)?/",
                "lookbehind" => true,
                "inside" => [
                    'each' => [
                        "pattern" => "/((?:^|\\n)[\\t ]*)each .+? in\b/",
                        "lookbehind" => true,
                        "inside" => [ 'keyword'=> "/\b(?:each|in)\b/", 'punctuation'=> "/,/" ]
                    ],
                    'branch' => [
                        "pattern" => "/((?:^|\\n)[\\t ]*)(?:if|unless|else|case|when|default|while)/",
                        "lookbehind" => true,
                        "alias" => 'keyword'
                    ],
                    "rest" => $this->getDefinition('javascript')
                ]
            ],
            'keyword' => [
                "pattern" => "/((?:^|\\n)[\\t ]*)(?:block|extends|include|append|prepend)\b.+/",
                "lookbehind" => true
            ],
            'mixin'=> [
                [ // Declaration
                    "pattern" => "/((?:^|\\n)[\\t ]*)mixin .+/",
                    "lookbehind" => true,
                    "inside" => [
                        'keyword'=> "/^mixin/",
                        'function'=> "/\w+(?=\s*\(|\s*$)/",
                        'punctuation'=> "/[(),.]/"
                    ]
                ],
                [ // Usage
                    "pattern" => "/((?:^|\\n)[\\t ]*)\+.+/",
                    "lookbehind" => true,
                    "inside" => [
                        'name' => [ "pattern" => "/^\+\w+/", "alias" => 'function' ],
                        'rest'=> $this->getDefinition('javascript')
                    ]
                ]
            ],
            'script' => [
                "pattern" => "/((?:^|\\n)[\\t ]*script(?:(?:&[^(]+)?\([^)]+\))*) .+/",
                "lookbehind" => true,
                "inside" => [ "rest" => $this->getDefinition('javascript') ]
            ],
            'plain-text' => [
                    "pattern" => "/((?:^|\\n)[\\t ]*(?!-)[\w\-#.]*[\w\-](?:(?:&[^(]+)?\([^)]+\))*\/?[\\t ]+).+/",
                    "lookbehind" => true
            ],
            'tag' => [
                "pattern" => "/((?:^|\\n)[\\t ]*)(?!-)[\w\-#.]*[\w\-](?:(?:&[^(]+)?\([^)]+\))*\/?:?/",
                "lookbehind" => true,
                "inside" => [
                    'attributes' => [
                        [
                            "pattern" => "/&[^(]+\([^)]+\)/",
                            "inside" => [ "rest" => $this->getDefinition('javascript') ]
                        ],
                        [
                            "pattern" => "/\([^)]+\)/",
                            "inside" => [
                                'attr-value' => [
                                    "pattern" => "/(=\s*)(?:\{[^}]*\}|[^,)\\n]+)/",
                                    "lookbehind" => true,
                                    "inside" => [ "rest" => $this->getDefinition('javascript') ]
                                ],
                                'attr-name'=> "/[\w-]+(?=\s*!?=|\s*[,)])/",
                                'punctuation'=> "/[!=(),]/"
                            ]
                        ]
                    ],
                    'punctuation'=> "/[:]/"
                ]
            ],
            'code'=> [
                [
                    "pattern" => "/((?:^|\\n)[\\t ]*(?:-|!?=)).+/",
                    "lookbehind" => true,
                    "inside" => [ "rest" => $this->getDefinition('javascript') ]
                ]
            ],
            'punctuation'=> "/[.\-!=|]/"
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $filter_pattern = "/((?:^|\\n)([\\t ]*)):{{filter_name}}(\\n(?:\g{2}[\\t ]+.+|\s*?(?=\\n)))+/";

        // Non exhaustive list of available filters and associated languages
        $filters = [
            [ "filter" => 'atpl', "language" => 'twig' ],
            [ "filter" => 'coffee',"language" => 'coffeescript' ],
            'ejs',
            'handlebars',
            'hogan',
            'less',
            'livescript',
            'markdown',
            'mustache',
            'plates',
            [ "filter" => 'sass',"language" => 'scss' ],
            'stylus',
            'swig'
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
                        "rest"=> $this->getDefinition($filter['language'])
                    ]
                ];
            }
        }
        $this->insertBefore('jade', $all_filters, 'filter');
    }
}
