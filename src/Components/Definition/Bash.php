<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Bash script definition
 * @package VKBansal\Spectrum\Definition\Bash
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Bash extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'bash';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'comment'=> [
                "pattern"=> "/(^|[^\"{\\\\])(#.*?(\\r?\\n|$))/",
                "lookbehind"=> true
            ],
            'string'=> [
                //allow multiline string
                "pattern"=> "/(\"|')(\\\\?[\s\S])*?\g{1}/",
                "inside"=> [
                    //'property' class reused for bash variables
                    'property'=> "/\\\$([a-zA-Z0-9_#\?\-\*!@]+|\{[^\}]+\})/"
                ]
            ],
            'keyword' => "/\b(if|then|else|elif|fi|for|break|continue|while|in|case|function|select|do|done|until|echo|exit|return|set|declare)\b/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('bash', [
            //'property' class reused for bash variables
            "property"=> "/\\\$([a-zA-Z0-9_#\?\-\*!@]+|\{[^}]+\})/"
        ], 'keyword');

        $this->insertBefore('bash', [
            //shebang must be before comment, 'important' class from css reused
            'important'=> "/(^#!\s*\/bin\/bash)|(^#!\s*\/bin\/sh)/"
        ], 'comment');
    }
}
