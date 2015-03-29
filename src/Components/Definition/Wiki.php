<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Wiki definition
 * @package VKBansal\Spectrum\Definition\Wiki
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Wiki extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'wiki';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['markup'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('markup', [
            "block-comment" => [
                "pattern" => "/(^|[^\\\\])\\/\\*[\\w\\W]*?\\*\\//",
                "lookbehind" => true,
                "alias" => 'comment'
            ],
            "heading" => [
                "pattern" => "/^(=+).+?\\g{1}/m",
                "inside" => [
                    "punctuation" => "/^=+|=+$/",
                    "important" => "/.+/"
                ]
            ],
            "emphasis" => [
                "pattern" => "/('{2,4}).+?\\g{1}/",
                "inside" => [
                    "bold italic" => [
                        "pattern" => "/('''').+?(?=\\g{1})/",
                        "lookbehind" => true
                    ],
                    "bold" => [
                        "pattern" => "/(''').+?(?=\\g{1})/",
                        "lookbehind" => true
                    ],
                    "italic" => [
                        "pattern" => "/('').+?(?=\\g{1})/",
                        "lookbehind" => true
                    ],
                    "punctuation" => "/^''+|''+$/"
                ]
            ],
            "hr" => [
                "pattern" => "/^-{4,}/m",
                "alias" => 'punctuation'
            ],
            "url" => [
                "/ISBN +(?:97[89][ -]?)?(?:\\d[ -]?){9}[\\dx]\\b/i",
                "/(?:RFC|PMID) +\\d+/",
                "/\\[\\[.+?\\]\\]/",
                "/\\[.+?\\]/"
            ],
            "variable" => [
                "/__[A-Z]+__/",
                "/\\{{3}.+?\\}{3}/",
                "/\\{\\{.+?}}/"
            ],
            "symbol" => [
                "/^#redirect/im",
                "/~{3,5}/"
            ],
            // Handle table attrs:
            // {|
            // ! style="text-align:left;"| Item
            // |}
            "table-tag" => [
                "pattern" => "/((?:^|[|!])[|!])[^|\\r\\n]+\\|(?!\\|)/m",
                "lookbehind" => true,
                "inside" => [
                "table-bar" => [
                    "pattern" => "/\\|$/",
                        "alias" => 'punctuation'
                    ],
                    "rest" => $this->getDefinition('markup.tag.inside')
                ]
            ],
            "punctuation" => "/^(?:\\{\\||\\|\\}|\\|-|[*#:;!|])|\\|\\||!!/m"
        ]);
    }

    public function setUp()
    {
        $this->insertBefore('wiki', [
            "nowiki" => [
		        "pattern" => "/<(nowiki|pre|source)\\b[\\w\\W]*?>[\\w\\W]*?<\\/\\g{1}>/i",
                "inside" => [
                    "tag" => [
                        "pattern" => "/<(?:nowiki|pre|source)\\b[\\w\\W]*?>|<\\/(?:nowiki|pre|source)>/i",
                        "inside" => $this->getDefinition('markup.tag.inside')
                    ]
                ]
            ]
        ], 'tag');
    }
}
