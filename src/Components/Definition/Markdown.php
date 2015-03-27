<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Markdown definition
 * @package VKBansal\Spectrum\Definition\Markdown
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Markdown extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'markdown';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['markup'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->getDefinition('markup');
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $markdown = [
            'blockquote' => [
                // > ...
                'pattern' => "/(^|\\n)>(?:[\\t ]*>)*/",
                'lookbehind' => true,
                'alias' => 'punctuation'
            ],
            'code' => [
                [
                    // Prefixed by 4 spaces or 1 tab
                    'pattern' => "/(^|\\n)(?: {4}|\\t).+/",
                    'lookbehind' => true,
                    'alias' => 'keyword'
                ],
                [
                    // `code`
                    // ``code``
                    'pattern' => "/``.+?``|`[^`\\n]+`/",
                    'alias' => 'keyword'
                ]
            ],
            'title' => [
                [
                    // title 1
                    // =======

                    // title 2
                    // -------
                    'pattern' => "/\\w+.*\\n(?:==+|--+)/",
                    'alias' => 'important',
                    'inside' => [
                        'punctuation' => "/==+$|--+$/"
                    ]
                ],
                [
                    // # title 1
                    // ###### title 6
                    'pattern' => "/((?:^|\\n)\\s*)#+.+/",
                    'lookbehind' => true,
                    'alias' => 'important',
                    'inside' => [
                        'punctuation' => "/^#+|#+$/"
                    ]
                ]
            ],
            'hr' => [
                // ***
                // ---
                // * * *
                // -----------
                'pattern' => "/((?:^|\\n)\\s*)([*-])([\\t ]*\\g{2}){2,}(?=\\s*(?:\\n|$))/",
                'lookbehind' => true,
                'alias' => 'punctuation'
            ],
            'list' => [
                // * item
                // + item
                // - item
                // 1. item
                'pattern' => "/((?:^|\\n)\\s*)(?:[*+-]|\\d+\\.)(?=[\\t ].)/",
                'lookbehind' => true,
                'alias' => 'punctuation'
            ],
            'url-reference' => [
                // [id]: http://example.com "Optional title"
                // [id]: http://example.com 'Optional title'
                // [id]: http://example.com (Optional title)
                // [id]: <http://example.com> "Optional title"
                'pattern' => "/!?\\[[^\\]]+\\]:[\\t ]+(?:\\S+|<(?:[^>]|\\\\>)+>)(?:[\\t ]+(?:\"(?:[^\"]|\\\\\")*\"|'(?:[^']|\\\\')*'|\\((?:[^)]|\\\\\\))*\\)))?/",
                'inside' => [
                    'variable' => [
                        'pattern' => "/^(!?\\[)[^\\]]+/",
                        'lookbehind' => true
                    ],
                    'string' => "/(?:\"(?:[^\"]|\\\\\")*\"|'(?:[^']|\\\\')*'|\\((?:[^)]|\\\\\\))*\\))$/",
                    'punctuation' => "/[[\\]\\(\\)<>:]/"
                ],
                'alias' => 'url'
            ],
            'bold' => [
                // **strong**
                // __strong__

                // Allow only one line break
                'pattern' => "/(^|[^\\\\])(\\*\\*|__)(?:\\n(?!\\n)|.)+?\\g{2}/",
                'lookbehind' => true,
                'inside' => [
                    'punctuation' => "/^\\*\\*|^__|\\*\\*\\s*$|__\\s*$/"
                ]
            ],
            'italic' => [
                // *em*
                // _em_

                // Allow only one line break
                'pattern' => "/(^|[^\\\\])(?:\\*(?:\\n(?!\\n)|.)+?\\*|_(?:\\n(?!\\n)|.)+?_)/",
                'lookbehind' => true,
                'inside' => [
                    'punctuation'=> "/^[*_]|[*_]$/"
                ]
            ],
            'url' => [
                // [example](http://example.com "Optional title")
                // [example] [id]
                'pattern' => "/!?\\[[^\\]]+\\](?:\\([^\\s)]+(?:[\\t ]+\"(?:[^\"]|\\\\\")*\")?\\)| ?\\[[^\\]\\n]*\\])/",
                'inside' => [
                    'variable' => [
                        'pattern' => "/(!?\\[)[^\\]]+(?=\\]$)/",
                        'lookbehind' => true
                    ],
                    'string' => [
                        'pattern' => "/\"(?:[^\"]|\\\\\")*\"(?=\\)$)/"
                    ]
                ]
            ]
        ];

        $this->insertBefore('markdown', $markdown, 'prolog');

        $lang = &$this->getDefinition('markdown');
        $lang['bold']['inside']['url'] = $this->getDefinition('markdown.url');
        $lang['italic']['inside']['url'] = $this->getDefinition('markdown.url');
        $lang['bold']['inside']['italic'] = $this->getDefinition('markdown.italic');
        $lang['italic']['inside']['bold'] = $this->getDefinition('markdown.bold');
    }
}
