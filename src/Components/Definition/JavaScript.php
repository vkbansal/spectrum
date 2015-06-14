<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * JavaScript definition
 * @package VKBansal\Spectrum\Definition\JavaScript
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class JavaScript extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'javascript';

    /**
     * {@inheritdoc}
     */
    protected static $aliases = ['js'];

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['clike', 'markup'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('clike', [
            'keyword' => "/\\b(as|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|false|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|true|try|typeof|var|void|while|with|yield)\\b/",
            "number" => "/\\b-?(0x[\\dA-Fa-f]+|0b[01]+|0o[0-7]+|\\d*\\.?\\d+([Ee][+-]?\\d+)?|NaN|-?Infinity)\\b/",
            "function" => "/(?!\\d)[a-z0-9_$]+(?=\\()/i"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('javascript', [
            'regex'=> [
                "pattern"=> "/(^|[^\\/])\\/(?!\\/)(\\[.+?]|\\\\.|[^\\/\\r\\n])+\\/[gimyu]{0,5}(?=\\s*($|[\\r\\n,.;})]))/",
                "lookbehind"=> true
            ]
        ], 'keyword');
        
        $this->insertBefore('javascript', [
        	'template-string'=> [
        		"pattern"=> "/`(?:\\\\`|\\\\?[^`])*`/",
        		"inside"=> [
        			'interpolation' => [
        				"pattern"=> "/\\$\\{[^}]+\\}/",
        				"inside"=> [
        					'interpolation-punctuation'=> [
        						"pattern"=> "/^\\$\\{|\\}$/",
        						"alias"=> 'punctuation'
                        ],
        				"rest"=> $this->getDefinition("javascript")
                    ],
                 ],
    			'string'=> "/[\\s\\S]+/"
                ]
            ]
        ], 'string');

        $this->insertBefore('markup', [
            "script" => [
                "pattern" => "/<script[\\w\\W]*?>[\\w\\W]*?<\\/script>/i",
                "inside" => [
                    'tag' => [
                        "pattern" => "/<script[\\w\\W]*?>|<\\/script>/i",
                        "inside" =>  $this->getDefinition('markup.tag.inside')
                    ],
                    "rest" => $this->getDefinition('javascript')
                ],
                "alias" => 'language-javascript'
            ]
        ], 'tag');
    }
}
