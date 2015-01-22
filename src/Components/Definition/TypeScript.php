<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * TypeScript definition
 * @package VKBansal\Prism\Definition\TypeScript
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class TypeScript extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'typescript';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['javascript'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('javascript', [
            'keyword' => "/\b(break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|false|finally|for|function|get|if|implements|import|in|instanceof|interface|let|new|null|package|private|protected|public|return|set|static|super|switch|this|throw|true|try|typeof|var|void|while|with|yield|module|declare|constructor|string|Function|any|number|boolean|Array|enum)\b/"
        ]);
    }
}
