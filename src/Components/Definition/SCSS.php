<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * SASS\SCSS definition
 * @package VKBansal\Spectrum\Definition\Sass
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class SCSS extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'scss';

    /**
     * {@inheritdoc}
     */
    protected static $aliases = ['sass'];

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['css'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('css', [
            'comment' => [
                "pattern" => "/(^|[^\\\\])(\\/\\*[\\w\\W]*?\\*\\/|\\/\\/.*?(\\r?\\n|$))/",
                "lookbehind" => true
            ],
            // aturle is just the @***, not the entire rule (to highlight var & stuffs)
            // + add ability to highlight number & unit for media queries
            'atrule' => "/@[\\w-]+(?=\\s+(\\(|\\{|;))/i",
            // url, compassified
            'url' => "/([-a-z]+-)*url(?=\\()/i",
            // CSS selector regex is not appropriate for Sass
            // since there can be lot more things (var, @ directive, nesting..)
            // a selector must start at the end of a property or after a brace (end of other rules or nesting)
            // it can contain some caracters that aren't used for defining rules or end of selector, & (parent selector), or interpolated variable
            // the end of a selector is found when there is no rules in it ( {} or {\s}) or if there is a property (because an interpolated var
            // can "pass" as a selector- e.g: proper#{$erty})
            // this one was ard to do, so please be careful if you edit this one :)
            'selector' => "/([^@;\\{\\}\\(\\)]?([^@;\\{\\}\\(\\)]|&|#\\{\\$[-_\\w]+\\})+)(?=\\s*\\{(\\}|\\s|[^\\}]+(:|\\{)[^\\}]+))/m"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('scss', [
            'keyword' => "/@(if|else if|else|for|each|while|import|extend|debug|warn|mixin|include|function|return|content)|(?=@for\\s+\\\$[-_\\w]+\\s)+from/i"
        ], 'atrule');

        $this->insertBefore('scss', [
            // var and interpolated vars
            'variable' => "/((\\$[-_\\w]+)|(#\\{\\$[-_\\w]+\\}))/i"
        ], 'property');

        $this->insertBefore('scss', [
            'placeholder' => "/%[-_\\w]+/i",
            'statement' => "/\\B!(default|optional)\\b/i",
            'boolean' => "/\\b(true|false)\\b/",
            'null' => "/\\b(null)\\b/",
            'operator' => "/\\s+([-+]{1,2}|={1,2}|!=|\\|?\\||\\?|\\*|\\/|%)\\s+/"
        ], 'function');
    }
}
