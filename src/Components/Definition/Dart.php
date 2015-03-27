<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Dart definition
 * @package VKBansal\Spectrum\Definition\Dart
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Dart extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'dart';

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
            'string' => [
                "/r?(\"\"\"|''')[\\s\\S]*?\\g{1}/",
                "/r?(\"|')(\\\\?.)*?\\g{1}/"
            ],
            'keyword' => [
                "/\\b(?:async|sync|yield)\\*/",
                "/\\b(?:abstract|assert|async|await|break|case|catch|class|const|continue|default|deferred|do|dynamic|else|enum|export|external|extends|factory|final|finally|for|get|if|implements|import|in|library|new|null|operator|part|rethrow|return|set|static|super|switch|this|throw|try|typedef|var|void|while|with|yield)\\b/"
            ],
            'operator' => "/\\bis!|\\b(?:as|is)\\b|\\+\\+|--|&&|\\|\\||<<=?|>>=?|~(?:\\/=?)?|[+\\-*\\/%&^|=!<>]=?|\\?/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('dart', [
            'metadata' => [
                "pattern" => "/@\\w+/",
                "alias" => 'symbol'
            ]
        ], 'function');
    }
}
