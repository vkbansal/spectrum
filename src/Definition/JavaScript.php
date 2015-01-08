<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * JavaScript definition
 * @package VKBansal\Prism\Definition\JavaScript
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class JavaScript extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'javascript';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'keyword' => "/\b(break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|false|finally|for|function|get|if|implements|import|in|instanceof|interface|let|new|null|package|private|protected|public|return|set|static|super|switch|this|throw|true|try|typeof|var|void|while|with|yield)\b/",
            "number" => "/\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee][+-]?\d+)?|NaN|-?Infinity)\b/",
            "function" => "/(?!\d)[a-z0-9_$]+(?=\()/i"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('javascript', [
            'regex'=> [
                "pattern"=> "/(^|[^\/])\/(?!\/)(\[.+?]|\\\\.|[^\/\\r\\n])+\/[gim]{0,3}(?=\s*($|[\\r\\n,.;})]))/",
                "lookbehind"=> true
            ]
        ], 'keyword');
        
        $markup = $this->hasDefinition('markup');
        
        if ($markup) {
            $inside = $this->getDefinition('markup.tag.inside');

            $this->insertBefore('markup', [
                "script"=> [
                    "pattern"=> "/<script[\w\W]*?>[\w\W]*?<\/script>/i",
                    "inside"=> [
                        'tag'=> [
                            "pattern"=> "/<script[\w\W]*?>|<\/script>/i",
                            "inside"=> $inside
                        ],
                        "rest" => $this->getDefinition('javascript')
                    ],
                    "alias"=> 'language-javascript'
                ]
            ], 'tag');
        }
    }
}
