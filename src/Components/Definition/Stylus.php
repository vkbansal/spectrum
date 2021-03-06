<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Stylus definition
 * @package VKBansal\Spectrum\Definition\Stylus
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Stylus extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'stylus';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            "comment"=> [
                "pattern"=> "/(^|[^\\\\])(\\/\\*[\\w\\W]*?\\*\\/|\\/\\/.*?(\\r?\\n|$))/",
                "lookbehind"=> true
            ],
            "keyword"=> "/(px|r?em|ex|ch|vw|vh|vmin|vmax|deg|grad|rad|turn|m?s|k?Hz|dpi|dppx|dpcm)\\b|\\b(is|defined|not|isnt|and|or|unless|for|in)\\b/",
            "atrule"=> "/@[\\w-]+(?=\\s+\\S+)/i",
            "url"=> "/url\\(([\"']?).*?\\g{1}\\)/i",
            "variable"=> "/^\\s*([\\w-]+)(?=\\s*[+-\\\\]?=)/m",
            "string"=> "/(\"|')(\\\\\\n|\\\\?.)*?\\g{1}/",
            "important"=> "/\\B!important\\b/i",
            "hexcode"=> "/#[\\da-f]{3,6}/i",
            "entity"=> "/\\\\[\\da-f]{1,8}/i",
            "number"=> "/\\d+\\.?\\d*%?/",
            "selector"=> [
                [
                    "pattern"=> "/::?(after|before|first-letter|first-line|selection)/",
                    "alias"=> 'pseudo-element'
                ],[
                    "pattern"=> "/:(?:active|checked|disabled|empty|enabled|first-child|first-of-type|focus|hover|in-range|invalid|lang|last-child|last-of-type|link|not|nth-child|nth-last-child|nth-last-of-type|nth-of-type|only-of-type|only-child|optional|out-of-range|read-only|read-write|required|root|target|valid|visited)(?:\\(.*\\))?/",
                    "alias"=>'pseudo-class'
                ],[
                    "pattern"=> "/\\[[\\w-]+?\\s*[*~$^|=]?(?:=\\s*\\S+)?\\]/",
                    "inside"=> [
                        "attr-name"=>
                        [
                            "pattern"=> "/(\\[)([\\w-]+)(?=\\s*[*~$^|=]{0,2})/",
                            "lookbehind"=> true
                        ],
                        "punctuation" => "/\\[|\\]/",
                        "operator" => "/[*~$^|=]/",
                        "attr-value" => [
                            "pattern"=> "/\\S+/"
                        ],
                    ],
                    "alias"=> 'attr'
                ],
                [
                    "pattern"=> "/\\.[a-z-]+/i",
                    "alias"=> 'class'
                ],
                [
                    "pattern"=> "/#[a-z-]+/i",
                    "alias"=> 'id'
                ],
                [
                    "pattern"=> "/\\b(html|head|title|base|link|meta|style|script|noscript|template|body|section|nav|article|aside|h[1-6]|header|footer|address|main|p|hr|pre|blockquote|ol|ul|li|dl|dt|dd|figure|figcaption|div|a|em|strong|small|s|cite|q|dfn|abbr|data|time|code|var|samp|kbd|sub|sup|i|b|u|mark|ruby|rt|rp|bdi|dbo|span|br|wbr|ins|del|image|iframe|embed|object|param|video|audio|source|track|canvas|map|area|sv|math|table|caption|colgroup|col|tbody|thead|tfoot|tr|td|th|form|fieldset|legeng|label|input|button|select|datalist|optgroup|option|textarea|keygen|output|progress|meter|details|summary|menuitem|menu)\\b/",
                    "alias"=> 'tag'
                ],
            ],
            "property"=> [
                "/^\\s*([a-z-]+)(?=\\s+[\\w\\W]+|\\s*:)(?!\\s*\\{|\\r?\\n)/im",
                [
                    "pattern"=> "/(\\(\\s*)([a-z-]+)(?=\\s*:)/i",
                    "lookbehind"=> true
                ]
            ],
            "function"=> "/[-a-z0-9]+(?=\\()/i",
            "punctuation"=> "/[\\{\\};:]/",
            "operator"=> "/[-+]{1,2}|!|<=?|>=?|={1,3}|&{1,2}|\\|?\\||\\?|\\*|\\/|~|\\^|%/"
        ];
    }
}
