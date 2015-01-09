<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * CSS definition
 * @package VKBansal\Prism\Definition\CSS
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class CSS extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'css';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            "comment" => "/\/\*[\w\W]*?\*\//",
            "atrule" => [
                "pattern" => "/@[\w-]+?.*?(;|(?=\s*{))/i",
                "inside" => [
                    "punctuation" => "/[;:]/"
                ]
            ],
            "url" => "/url\(([\"']?).*?\g{1}\)/i",
            //"selector" => "/[^\{\}\s][^\{\};]*(?=\s*\{)/",
            "selector" => [
                "pattern" => "/[^\{\}\s][^\{\}]*(?=\s*\{)/",
                "inside" => [
                    "pseudo-element"=> "/:(?:after|before|first-letter|first-line|selection)|::[-\w]+/",
                    "pseudo-class"=> "/:[-\w]+(?:\(.*\))?/",
                    "class"=> "/\.[-:\.\w]+/",
                    "id"=> "/#[-:\.\w]+/"
                ]
            ],
            "property" => "/(\b|\B)[\w-]+(?=\s*:)/i",
            "string" => "/(\"|')(\\\\?.)*?\g{1}/",
            "important" => "/\B!important\b/i",
            "punctuation" => "/[\{\};:]/",
            "function" => "/[-a-z0-9]+(?=\()/i",
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $markup = $this->hasDefinition('markup');

         $this->insertBefore('css', [
            'hexcode'=> "/#[\da-f]{3,6}/i",
            'entity' => "/\\\\[\da-f]{1,8}/i",
            'number' => "/[\d%\.]+/"
        ], 'function');

        if ($markup) {
            $inside = $this->getDefinition('markup.tag.inside');

            $this->insertBefore('markup', [
                'style' => [
                    "pattern" => "/<style[\w\W]*?>[\w\W]*?<\/style>/i",
                    "inside" => [
                        'tag'=> [
                            "pattern" => "/<style[\w\W]*?>|<\/style>/i",
                            "inside" => $inside
                        ],
                        "rest" => $this->getDefinition('css')
                    ],
                    "alias" => 'language-css'
                ]
            ], 'tag');

            $this->insertBefore('markup.tag.inside', [
                'style-attr'=> [
                    "pattern"=> "/\s*style=(\"|').+?\g{1}/i",
                    "inside"=> [
                        "attr-name"=> [
                            "pattern"=> "/^\s*style/i",
                            "inside" => $inside
                        ],
                        'punctuation' => "/^\s*=\s*['\"]|['\"]\s*$/",
                        'attr-value'=> [
                            "pattern"=> "/.+/i",
                            "inside" => $this->getDefinition('css')
                        ]
                    ],
                    "alias" => 'language-css'
                ]
            ], 'attr-value');
        }
    }
}
