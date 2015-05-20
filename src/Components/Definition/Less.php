<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * LESS CSS definition
 * @package VKBansal\Spectrum\Definition\Less
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Less extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'less';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['css'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        /*
         :extend() is not handled specifically : its highlighting is buggy.
         Mixin usage must be inside a ruleset to be highlighted.
         At-rules (e.g. import) containing interpolations are buggy.
         Detached rulesets are highlighted as at-rules.
         A comment before a mixin usage prevents the latter to be properly highlighted.
         */
        return $this->extend('css', [
            'comment'=> [
                "/\\/\\*[\\w\\W]*?\\*\\//",
                [
                    "pattern"=> "/(^|[^\\\\])\\/\\/.*/",
                    "lookbehind"=> true
                ]
            ],
            'atrule'=> [
                "pattern"=> "/@[\\w-]+?(?:\\([^{}]+\\)|[^(){};])*?(?=\\s*\\{)/i",
                "inside"=> [
                    'punctuation'=> "/[:()]/"
                ]
            ],
            // selectors and mixins are considered the same
            'selector'=> [
                "pattern"=> "/(?:@\\{[\\w-]+\\}|[^{};\\s@])(?:@\\{[\\w-]+\\}|\\([^{}]*\\)|[^{};@])*?(?=\\s*\\{)/",
                "inside"=> [
                    // mixin parameters
                    'variable'=> "/@+[\\w-]+/"
                ]
            ],
            'property'=> "/(\\b|\\B)(?:@\\{[\\w-]+\\}|[\\w-])+(?:\\+_?)?(?=\\s*:)/i",
            'punctuation'=> "/[{}();:,]/",
            'operator'=> "/[+\\-*\\/]/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        // Invert function and punctuation positions
        $function = $this->getDefinition('less.function');

        $this->insertBefore('less', [
            'function'=> $function
        ], 'punctuation');

        $this->insertBefore('less', [
            'variable'=> [
                // Variable declaration (the colon must be consumed!)
                [
                    "pattern"=> "/@[\\w-]+\\s*:/",
                    "inside"=> [
                        "punctuation"=> "/:/"
                    ]
                ],
                // Variable usage
                "/@@?[\\w-]+/"
            ],
            'mixin-usage'=> [
                "pattern"=> "/([{;]\\s*)[.#](?!\\d)[\\w-]+.*?(?=[(;])/",
                "lookbehind" => true,
                "alias"=> 'function'
            ]
        ], 'property');
    }
}
