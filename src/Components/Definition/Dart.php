<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Dart definition
 * @package VKBansal\Prism\Definition\Dart
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Dart extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dart';
    }

    /**
     * {@inheritdoc}
     */
    public function requires()
    {
        return ['clike'];
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'string' => [
                "/r?(\"\"\"|''')[\s\S]*?\g{1}/",
                "/r?(\"|')(\\\\?.)*?\g{1}/"
            ],
            'keyword' => [
                "/\b(?:async|sync|yield)\*/",
                "/\b(?:abstract|assert|async|await|break|case|catch|class|const|continue|default|deferred|do|dynamic|else|enum|export|external|extends|factory|final|finally|for|get|if|implements|import|in|library|new|null|operator|part|rethrow|return|set|static|super|switch|this|throw|try|typedef|var|void|while|with|yield)\b/"
            ],
            'operator' => "/\bis!|\b(?:as|is)\b|\+\+|--|&&|\|\||<<=?|>>=?|~(?:\/=?)?|[+\-*\/%&^|=!<>]=?|\?/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('dart', [
            'metadata' => [
                "pattern" => "/@\w+/",
                "alias" => 'symbol'
            ]
        ], 'function');
    }
}
