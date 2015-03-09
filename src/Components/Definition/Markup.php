<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Definition for markup like HTML and XML
 * @package VKBansal\Spectrum\Definition\Markup
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Markup extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'markup';

    /**
     * {@inheritdoc}
     */
    protected static $default = true;

    /**
     * {@inheritdoc}
     */
    protected static $aliases = [
            'xml',
            'html',
            'atom',
            'epub',
            'mathml',
            'musicxml',
            'rss',
            'soap',
            'svg',
            'webfeed',
            'xform',
            'xhtml',
            'xpath',
            'xquery'
        ];

    /**
     * {@inheritdoc}
     */
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
            'entity'=> "/&#?[\da-z]{1,8};/i"
        ];
    }
}
