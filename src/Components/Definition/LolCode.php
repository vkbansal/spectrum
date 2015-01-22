<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Definition for markup like HTML and XML
 * @package VKBansal\Prism\Definition\LolCode
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class LolCode extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'lolcode';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => [
                "/\bOBTW\s+[\s\S]*?\s+TLDR\b/",
                "/\bBTW.+/"
            ],
            'string' => [
                'pattern' => "/\"(?::.|[^\"])*\"/",
                'inside' => [
                    'variable' => "/:\{[^}]+\}/",
                    'symbol' => [
                        "/:\([a-f\d]+\)/i",
                        "/:\[[^\]]+\]/",
                        "/:[)>o\":]/"
                    ]
                ]
            ],
            'number' => "/(-|\b)\d*\.?\d+/",
            'symbol' => [
                'pattern' => "/(^|\s)(?:A )?(?:YARN|NUMBR|NUMBAR|TROOF|BUKKIT|NOOB)(?=\s|,|$)/",
                'lookbehind' => true,
                'inside' => [
                    'keyword' => "/A(?=\s)/"
                ]
            ],
            'label' => [
                'pattern' => "/((?:^|\s)(?:IM IN YR|IM OUTTA YR) )[a-zA-Z]\w*/",
                'lookbehind' => true,
                'alias' => 'string'
            ],
            'function' => [
                'pattern' => "/((?:^|\s)(?:I IZ|HOW IZ I|IZ) )[a-zA-Z]\w*/",
                'lookbehind' => true
            ],
            'keyword' => [
                [
                    'pattern' => "/(^|\s)(?:O HAI IM|KTHX|HAI|KTHXBYE|I HAS A|ITZ(?: A)?|R|AN|MKAY|SMOOSH|MAEK|IS NOW(?: A)?|VISIBLE|GIMMEH|O RLY\?|YA RLY|NO WAI|OIC|MEBBE|WTF\?|OMG|OMGWTF|GTFO|IM IN YR|IM OUTTA YR|FOUND YR|YR|TIL|WILE|UPPIN|NERFIN|I IZ|HOW IZ I|IF U SAY SO|SRS|HAS A|LIEK(?: A)?|IZ)(?=\s|,|$)/",
                    'lookbehind' => true
                ],
                "/'Z(?=\s|,|$)/"
            ],
            'boolean' => [
                'pattern' => "/(^|\s)(?:WIN|FAIL)(?=\s|,|$)/",
                'lookbehind' => true
            ],
            'variable' => [
                'pattern' => "/(^|\s)(?:IT)(?=\s|,|$)/",
                'lookbehind' => true
            ],
            'operator' => [
                'pattern' => "/(^|\s)(?:NOT|BOTH SAEM|DIFFRINT|(?:SUM|DIFF|PRODUKT|QUOSHUNT|MOD|BIGGR|SMALLR|BOTH|EITHER|WON|ALL|ANY) OF)(?=\s|,|$)/",
                'lookbehind' => true
            ],
            'punctuation' => "/\.{3}|\x{2026}|,|!/u"
        ];
    }
}
