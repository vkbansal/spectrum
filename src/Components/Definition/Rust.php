<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Rust definition
 * @package VKBansal\Spectrum\Definition\Rust
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Rust extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'rust';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        /*
            Add support for Markdown notation inside doc comments
            Add support for nested block comments...
            Match closure params even when not followed by dash or brace
            Add better support for macro definition
        */
        return [
            'comment' => [
                [
                    'pattern' => "/(^|[^\\\\])\\/\\*[\\w\\W]*?\\*\\//",
                    'lookbehind' => true
                ],
                [
                    'pattern' => "/(^|[^\\\\:])\\/\\/.*?(\\r?\\n|$)/",
                    'lookbehind' => true
                ]
            ],
            'string' => [
                "/b?r(#*)\"(?:\\\\?.)*?\"\\g{1}/",
                "/b?(\"|')(?:\\\\?.)*?\\g{1}/"
            ],
            'keyword' => "/\\b(?:abstract|alignof|as|be|box|break|const|continue|crate|do|else|enum|extern|false|final|fn|for|if|impl|in|let|loop|match|mod|move|mut|offsetof|once|override|priv|pub|pure|ref|return|sizeof|static|self|struct|super|true|trait|type|typeof|unsafe|unsized|use|virtual|where|while|yield)\\b/",
            'attribute' => [
                'pattern' => "/#!?\\[.+?\\]/",
                'alias' => 'attr-name'
            ],

            'function' => [
                "/[a-z0-9_]+(?=\\s*\\()/i",
                // Macros can use parens or brackets
                "/[a-z0-9_]+!(?=\\s*\\(|\\[)/i"
            ],
            'macro-rules' => [
                'pattern' => "/[a-z0-9_]+!/i",
                'alias' => 'function'
            ],

            // Hex, oct, bin, dec numbers with visual separators and type suffix
            'number' => "/\\b-?(?:0x[\\dA-Fa-f](?:_?[\\dA-Fa-f])*|0o[0-7](?:_?[0-7])*|0b[01](?:_?[01])*|(\\d(_?\\d)*)?\\.?\\d(_?\\d)*([Ee][+-]?\\d+)?)(?:_?(?:[iu](?:8|16|32)?|f32|f64))?\\b/",

            // Closure params should not be confused with bitwise OR |
            'closure-params' => [
                'pattern' => "/\\|[^|]*\\|(?=\\s*[{-])/",
                'inside' => [
                    'punctuation' => "/[\\|:,]/",
                    'operator' => "/[&*]/"
                ]
            ],
            'punctuation' => "/[{}[\\];(),.:]|->/",
            'operator' => "/[-+]{1,2}|!=?|<=?|>=?|={1,3}|&&?|\\|\\|?|\\*|\\/|\\^|%|<<|>>@/"
        ];
    }
}
