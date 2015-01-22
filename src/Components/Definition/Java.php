<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Java definition
 * @package VKBansal\Prism\Definition\Java
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Java extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'java';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['clike'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'keyword'=> "/\b(abstract|continue|for|new|switch|assert|default|goto|package|synchronized|boolean|do|if|private|this|break|double|implements|protected|throw|byte|else|import|public|throws|case|enum|instanceof|return|transient|catch|extends|int|short|try|char|final|interface|static|void|class|finally|long|strictfp|volatile|const|float|native|super|while)\b/",
            'number'=> "/\b0b[01]+\b|\b0x[\da-f]*\.?[\da-fp\-]+\b|\b\d*\.?\d+[e]?[\d]*[df]\b|\b\d*\.?\d+\b/i",
            'operator'=> [
                "pattern"=> "/(^|[^\.])(?:\+=|\+\+?|-=|--?|!=?|<{1,2}=?|>{1,3}=?|==?|&=|&&?|\|=|\|\|?|\?|\*=?|\/=?|%=?|\^=?|:|~)/m",
                "lookbehind"=> true
            ]
        ]);
    }
}
