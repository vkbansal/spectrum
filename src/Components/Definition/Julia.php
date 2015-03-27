<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Julia definition
 * @package VKBansal\Spectrum\Definition\Julia
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Julia extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'julia';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => [
                "pattern" => "/(^|[^\\\\])#.*?(\\r?\\n|$)/",
                "lookbehind" => true
            ],
            'string' => "/\"\"\"[\\s\\S]+?\"\"\"|'''[\\s\\S]+?'''|(\"|')(\\\\?.)*?\\g{1}/",
            'keyword' => "/\\b(abstract|baremodule|begin|bitstype|break|catch|ccall|const|continue|do|else|elseif|end|export|finally|for|function|global|if|immutable|import|importall|let|local|macro|module|print|println|quote|return|try|type|typealias|using|while)\\b/",
            'boolean' => "/\\b(true|false)\\b/",
            'number' => "/\\b-?(0[box])?(?:[\\da-f]+\\.?\\d*|\\.\\d+)(?:e[+-]?\\d+)?j?\\b/i",
            'operator' => "/[-+]{1,2}|=?<|=?>|!|={1,2}|&{1,2}|\\|?\\||\\?|\\*|\\/|~|\\^|%|\\b(or|and|not)\\b/",
            'punctuation' => "/[{}[\\];(),.:]/"
        ];
    }
}
