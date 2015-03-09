<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * React JSX definition
 * @package VKBansal\Spectrum\Definition\JSX
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class JSX extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'jsx';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['markup', 'javascript'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        $js = $this->getDefinition('javascript');
        return $this->extend('markup', $js);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $tag =& $this->getDefinition('jsx.tag');

        $tag['pattern'] = "/<\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:(\"|')(\\\\?[\w\W])*?\g{1}|[^\s'\">=]+|(\{[\w\W]*?\})))?\s*)*\/?>/i";

        $tag['inside']['attr-value']['pattern'] = "/=[^\{](?:('|\")[\w\W]*?(\g{1})|[^\s>]+)/i";

        $this->insertBefore('jsx.tag.inside', [
            "script" => [
                "pattern" => "/=(\{[\w\W]*?\})/i",
                "inside" => [
                    "function" => $this->getDefinition("javascript.function"),
                    "punctuation" => "/[={}[\];(),.:]/",
                    "keyword" => $this->getDefinition("javascript.keyword")
                ],
                "alias" => 'language-javascript'
            ]
        ], 'attr-value');
    }
}
