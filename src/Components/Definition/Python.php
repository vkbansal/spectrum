<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Python definition
 * @package VKBansal\Spectrum\Definition\Python
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Python extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'python';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment'=> [
                "pattern"=> "/(^|[^\\\\])#.*?(\\r?\\n|$)/",
                "lookbehind"=> true
            ],
            'string'=> "/\"\"\"[\\s\\S]+?\"\"\"|'''[\\s\\S]+?'''|(\"|')(\\\\?.)*?\\g{1}/",
            'keyword'=> "/\\b(as|assert|break|class|continue|def|del|elf|else|except|exec|finally|for|from|global|if|import|in|is|lambda|pass|print|raise|return|try|while|with|yield)\\b/",
            'boolean' => "/\\b(True|False)\\b/",
            'number' => "/\\b-?(0[box])?(?:[\\da-f]+\\.?\\d*|\\.\\d+)(?:e[+-]?\\d+)?j?\\b/i",
            'operator' => "/[-+]|<=?|>=?|!|={1,2}|&{1,2}|\\|?\\||\\?|\\*|\\/|~|\\^|%|\\b(or|and|not)\\b/",
            'punctuation' => "/[{}[\\];(),.:]/"
        ];
    }
}
