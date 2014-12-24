<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Definition\AbstractLanguage;

class CoffeeScript extends AbstractLanguage
{
    public function definition()
    {
        return $this->extend('javascript', [
            // Ignore comments starting with { to privilege string interpolation highlighting
            'comment'=> "/#(?!\{).+/",
            'string'=> [
                // Strings are multiline
                "/'(?:\\\\?[\s\S])*?'/",
                [
                    // Strings are multiline
                    "pattern"=> "/\"(?:\\\\?[\s\S])*?\"/",
                    "inside"=> [
                        'interpolation'=> [
                            "pattern"=> "/\#\{[^}]+\}/",
                            "alias"=> 'variable'
                        ]
                    ]
                ]
            ],
            'keyword'=> "/\b(and|break|by|catch|class|continue|debugger|delete|do|each|else|extend|extends|false|finally|for|if|in|instanceof|is|isnt|let|loop|namespace|new|no|not|null|of|off|on|or|own|return|super|switch|then|this|throw|true|try|typeof|undefined|unless|until|when|while|window|with|yes|yield)\b/",
            'class-member'=> [
                "pattern"=> "/@(?!\d)\w+/",
                "alias"=> 'variable'
            ]
        ]);
    }

    public function setup()
    {
        $comment = $this->prism->getDefinition('coffeescript.comment');
        $interpolation = $this->prism->getDefinition('coffeescript.string')[1]['inside']['interpolation'];

        $this->insertBefore('coffeescript', [
            'multiline-comment'=> [
                "pattern"=> "/\#\#\#[\s\S]+?\#\#\#/",
                "alias"=> 'comment'
            ],
            // Block regexp can contain comments and interpolation
            'block-regex'=> [
                "pattern"=> "/\/{3}[\s\S]*?\/{3}/",
                "alias"=> 'regex',
                "inside"=> [
                    'comment'=> $comment,
                    'interpolation'=> $interpolation
                ]
            ]
        ], 'comment');

        $this->insertBefore('coffeescript', [
            'inline-javascript'=> [
                "pattern"=> "/`(?:\\\\?[\s\S])*?`/",
                "inside"=> [
                    'delimiter'=> [
                        "pattern"=> "/^`|`$/",
                        "alias"=> 'punctuation'
                    ],
                    "rest"=> $this->prism->getDefinition('javascript')
                ]
            ],
            'multiline-string'=> [ // Block strings
                [
                    "pattern"=> "/'''[\s\S]*?'''/",
                    "alias"=> 'string'
                ],
                [
                    "pattern"=> '/"""[\s\S]*?"""/',
                    "alias"=> 'string',
                    "inside"=> [
                        "interpolation"=> $interpolation
                    ]
                ]
            ]

        ], 'string');

        $this->insertBefore('coffeescript', [
            'property'=> "/(?!\d)\w+(?=\s*:(?!:))/" // Object property
        ], 'keyword');
    }
}
