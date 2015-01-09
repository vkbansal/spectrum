<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Scala definition
 * @package VKBansal\Prism\Definition\Scala
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Scala extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'scala';
    }

    /**
     * {@inheritdoc}
     */
    public function requires()
    {
        return ['java'];
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
            return $this->extend('java', [
            'keyword' => "/(<-|=>)|\b(abstract|case|catch|class|def|do|else|extends|final|finally|for|forSome|if|implicit|import|lazy|match|new|null|object|override|package|private|protected|return|sealed|self|super|this|throw|trait|try|type|val|var|while|with|yield)\b/",
            'builtin' => "/\b(String|Int|Long|Short|Byte|Boolean|Double|Float|Char|Any|AnyRef|AnyVal|Unit|Nothing)\b/",
            'number' => "/\b0x[\da-f]*\.?[\da-f\-]+\b|\b\d*\.?\d+[e]?[\d]*[dfl]?\b/i",
            'symbol' => "/'([^\d\s]\w*)/",
            'string' => "/(\"\"\")[\W\w]*?\g{1}|(\"|\/)[\W\w]*?\g{2}|('.')/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $scala =& $this->getDefinition('scala');
        unset($scala['function']);
    }
}
