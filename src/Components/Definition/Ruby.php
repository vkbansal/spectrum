<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Ruby definition
 * @package VKBansal\Spectrum\Definition\Ruby
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Ruby extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'ruby';

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
            'comment'=> "/#[^\\r\\n]*(\\r?\\n|$)/",
            'keyword'=> "/\\b(alias|and|BEGIN|begin|break|case|class|def|define_method|defined|do|each|else|elsif|END|end|ensure|false|for|if|in|module|new|next|nil|not|or|raise|redo|require|rescue|retry|return|self|super|then|throw|true|undef|unless|until|when|while|yield)\\b/",
            'builtin'=> "/\\b(Array|Bignum|Binding|Class|Continuation|Dir|Exception|FalseClass|File|Stat|File|Fixnum|Fload|Hash|Integer|IO|MatchData|Method|Module|NilClass|Numeric|Object|Proc|Range|Regexp|String|Struct|TMS|Symbol|ThreadGroup|Thread|Time|TrueClass)\\b/",
            'constant'=> "/\\b[A-Z][a-zA-Z_0-9]*[?!]?\\b/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('ruby', [
            'regex'=> [
                "pattern"=> "/(^|[^\\/])\\/(?!\\/)(\\[.+?]|\\\\.|[^\\/\\r\\n])+\\/[gim]{0,3}(?=\\s*($|[\\r\\n,.;})]))/",
                "lookbehind"=> true
            ],
            'variable'=> "/[@$]+\\b[a-zA-Z_][a-zA-Z_0-9]*[?!]?\\b/",
            'symbol'=> "/:\\b[a-zA-Z_][a-zA-Z_0-9]*[?!]?\\b/"
        ], 'keyword');
    }
}
