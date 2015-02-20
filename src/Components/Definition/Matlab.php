<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Matlab definition
 * @package VKBansal\Spectrum\Definition\Matlab
 * @version 0.3.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Matlab extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'matlab';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            // We put string before comment, because of printf() patterns that contain "%"
            'string' => [
                'pattern' => "/(^|\W)'(?:''|[^'\\n])*'/",
                'lookbehind' => true
            ],
            'comment' => [
                "/%\{[\s\S]*?\}%/",
                "/%.+/"
            ],
            // We could handle imaginary numbers as a whole
            'number' => "/\b-?(?:\d*\.?\d+(?:[eE][+-]?\d+)?(?:[ij])?|[ij])\b/",
            'keyword' => "/\b(?:break|case|catch|continue|else|elseif|end|for|function|if|inf|NaN|otherwise|parfor|pause|pi|return|switch|try|while)\b/",
            'function' => "/(?!\d)\w+(?=\s*\()/",
            'operator' => "/\.?[*^\/\\\\']|[+\-:@]|[<>=~]=?|&&?|\|\|?/",
            'punctuation' => "/\.{3}|[.,;\[\](){}!]/"
        ];
    }
}
