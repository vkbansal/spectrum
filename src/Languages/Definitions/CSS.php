<?php
namespace VKBansal\Prism\Languages\Definitions;

use VKBansal\Prism\Languages\AbstractLanguage;

class CSS extends AbstractLanguage
{
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
                    "id"=> "/\#[-:\.\w]+/"
                ]
            ],
            "property" => "/(\b|\B)[\w-]+(?=\s*:)/i",
            "string" => "/(\"|')(\\\\?.)*?\g{1}/",
            "important" => "/\B!important\b/i",
            "punctuation" => "/[\{\};:]/",
            "function" => "/[-a-z0-9]+(?=\()/i",
        ];
    }

    public function setup()
    {
        $markup = $this->repository->hasDefinition('markup');

         $this->insertBefore('css', [
            'hexcode'=> "/\#[\da-f]{3,6}/i",
            'entity' => "/\\\\[\da-f]{1,8}/i",
            'number' => "/[\d%\.]+/"
        ], 'ignore');
        
        if ($markup) {
            $inside = $this->repository->getDefinition('markup.tag.inside');

            $this->insertBefore('markup', [
                'style' => [
                    "pattern" => "/<style[\w\W]*?>[\w\W]*?<\/style>/i",
                    "inside" => [
                        'tag'=> [
                            "pattern" => "/<style[\w\W]*?>|<\/style>/i",
                            "inside" => $inside
                        ],
                        "rest" => $this->definition()
                    ],
                    "alias" => 'language-css'
                ]
            ], 'tag');
            
            $this->insertBefore('markup.tag.inside', [
                'style-attr'=> [
                    "pattern"=> "/\s*style=(\"|').+?\1/i",
                    "inside"=> [
                        "attr-name"=> [
                            "pattern"=> "/^\s*style/i",
                            "inside" => $inside
                        ],
                        'punctuation' => "/^\s*=\s*['\"]|['\"]\s*$/",
                        'attr-value'=> [
                            "pattern"=> "/.+/i",
                            "inside" => $this->definition()
                        ]
                    ],
                    "alias" => 'language-css'
                ]
            ],'attr-value');
        }
    }
}
