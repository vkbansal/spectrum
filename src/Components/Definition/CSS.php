<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * CSS definition
 * @package VKBansal\Spectrum\Definition\CSS
 * @version 0.3.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class CSS extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'css';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['markup'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            "comment" => "/\/\*[\w\W]*?\*\//",
            "atrule" => [
                "pattern" => "/@[\w-]+?.*?(;|(?=\s*\{))/i",
                "inside" => [
                    "punctuation" => "/[;:]/"
                ]
            ],
            "url" => "/url\(([\"']?).*?\g{1}\)/i",
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
            "string" => "/(\"|')(\\\\\\n|\\\\?.)*?\g{1}/",
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
        $this->insertBefore('css', [
            'hexcode'=> "/#[\da-f]{3,6}/i",
            'entity' => "/\\\\[\da-f]{1,8}/i",
            'number' => "/[\d%\.]+/"
        ], 'function');

        $this->insertBefore('markup', [
            'style' => [
                "pattern" => "/<style[\w\W]*?>[\w\W]*?<\/style>/i",
                "inside" => [
                    'tag'=> [
                        "pattern" => "/<style[\w\W]*?>|<\/style>/i",
                        "inside" => $this->getDefinition('markup.tag.inside')
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
                        "inside" => $this->getDefinition('markup.tag.inside')
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
