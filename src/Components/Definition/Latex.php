<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Latex definition
 * @package VKBansal\Spectrum\Definition\Latex
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Latex extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'latex';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'comment' => "/%.*?(\\r?\\n|$)$/m",
            'string' => "/(\\$)(\\\\?.)*?\g{1}/",
            'punctuation' => "/[{}]/",
            'selector' => "/\\\\[a-z;,:\.]*/i"
        ];
    }
}
