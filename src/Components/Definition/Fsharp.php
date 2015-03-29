<?php
namespace VKBansal\Spectrum\Components\Definition;
use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * F# definition
 * @package VKBansal\Spectrum\Definition\Fsharp
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Fsharp extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'fsharp';

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
            'comment' => [
                [
                    "pattern"=> "/(^|[^\\\\])\\(\\*[\\w\\W]*?\\*\\)/",
                    "lookbehind" => true
                ],
                [
                    "pattern" => "/(^|[^\\\\:])\\/\\/.*/",
                    "lookbehind" => true
                ]
            ],
            'keyword' => "/\\b(abstract|and|as|assert|base|begin|class|default|delegate|do|done|downcast|downto|elif|else|end|exception|extern|false|finally|for|fun|function|global|if|in|inherit|inline|interface|internal|lazy|let|let!|match|member|module|mutable|namespace|new|not|null|of|open|or|override|private|public|rec|return|return!|select|static|struct|then|to|true|try|type|upcast|use|use!|val|void|when|while|with|yield|yield!|asr|land|lor|lsl|lsr|lxor|mod|sig|atomic|break|checked|component|const|constraint|constructor|continue|eager|event|external|fixed|functor|include|method|mixin|object|parallel|process|protected|pure|sealed|tailcall|trait|virtual|volatile)\\b/",
            'string' => "/@?(\"\"\"|\"|')((\\\\|\\n)?.)*?\\g{1}B?/",
            'preprocessor' => "/^\\s*#.*/m",
            'number' => [
                "/\\b-?0x[\\da-fA-F]+(un|lf|LF)?\\b/",
                "/\\b-?0b[01]+(y|uy)?\\b/",
                "/\\b-?(\\d+\\.|\\d*\\.?\\d+)([fFmM]|[eE][+-]?\\d+)?\\b/",
                "/\\b-?\\d+(y|uy|s|us|l|u|ul|L|UL|I)?\\b/"
            ]
        ]);
    }
}
