<?php
namespace VKBansal\Prism\Definition;

class Markup extends AbstractLanguage
{
    public function definition()
    {
        return [
            'comment'=> "/<!--[\w\W]*?-->/",
            'prolog'=> "/<\?.+?\?>/",
            'doctype'=> "/<!DOCTYPE.+?>/",
            'cdata'=> "/<!\[CDATA\[[\w\W]*?]]>/i",
            "tag"=> [
                "pattern"=> "/<\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:(\"|')(\\\\?[\w\W])*?\g{1}|[^\s'\">=]+))?\s*)*\/?>/i",
                "inside"=> [
                    "tag"=> [
                        "pattern"=> "/^<\/?[\w:-]+/i",
                        "inside"=> [
                            'punctuation'=> "/^<\/?/",
                            'namespace'=> "/^[\w-]+?:/"
                        ]
                    ],
                    'attr-value'=> [
                        "pattern" => "/=(?:('|\")[\w\W]*?(\g{1})|[^\s>]+)/i",
                        "inside" => [
                            'punctuation'=> "/=|>|\"/"
                        ]
                    ],
                    'punctuation'=> "/\/?>/",
                    'attr-name'=> [
                        "pattern"=> "/[\w:-]+/",
                        "inside"=> [
                            "namespace"=> "/^[\w-]+?:/"
                        ]
                    ]
                ]
            ],
            'entity'=> "/\&#?[\da-z]{1,8};/i"
        ];
    }
}
