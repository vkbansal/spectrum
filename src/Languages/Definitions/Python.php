<?php
namespace VKBansal\Prism\Languages\Definitions;

use VKBansal\Prism\Languages\AbstractLanguage;

class Python extends AbstractLanguage
{
    public function definition()
    {
        return [
            'comment'=> [
                "pattern"=> "/(^|[^\\\\])\#.*?(\r?\n|$)/",
                "lookbehind"=> true
            ],
            'string'=> "/\"\"\"[\s\S]+?\"\"\"|'''[\s\S]+?'''|(\"|')(\\\\?.)*?\g{1}/",
            'keyword'=> "/\b(as|assert|break|class|continue|def|del|elif|else|except|exec|finally|for|from|global|if|import|in|is|lambda|pass|print|raise|return|try|while|with|yield)\b/",
            'boolean' => "/\b(True|False)\b/",
            'number' => "/\b-?(0[box])?(?:[\da-f]+\.?\d*|\.\d+)(?:e[+-]?\d+)?j?\b/i",
            'operator' => "/[-+]{1,2}|=?&lt;|=?&gt;|!|={1,2}|(&){1,2}|(&amp;){1,2}|\|?\||\?|\*|\/|~|\^|%|\b(or|and|not)\b/",
            'ignore' => "/&(lt|gt|amp);/i",
            'punctuation' => "/[{}[\];(),.:]/"
        ];
    }
}
