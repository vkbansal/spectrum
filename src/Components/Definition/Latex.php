<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Latex definition
 * @package VKBansal\Prism\Definition\Latex
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Latex extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'latex';
    }

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
