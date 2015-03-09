<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Groovy definition
 * @package VKBansal\Spectrum\Definition\Groovy
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Groovy extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'groovy';

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
            'keyword' => "/\b(as|def|in|abstract|assert|boolean|break|byte|case|catch|char|class|const|continue|default|do|double|else|enum|extends|final|finally|float|for|goto|if|implements|import|instanceof|int|interface|long|native|new|package|private|protected|public|return|short|static|strictfp|super|switch|synchronized|this|throw|throws|trait|transient|try|void|volatile|while)\b/",
            'string' => "/(\"\"\"|''')[\W\w]*?\g{1}|(\"|'|\/)(?:\\\\?.)*?\g{2}|(\\$\/)(\\$\/\\$|[\W\w])*?\/\\$/",
            'number' => "/\b0b[01_]+\b|\b0x[\da-f_]+(\.[\da-f_p\-]+)?\b|\b[\d_]+(\.[\d_]+[e]?[\d]*)?[glidf]\b|[\d_]+(\.[\d_]+)?\b/i",
            'operator' => [
                "pattern" => "/(^|[^.])(={0,2}~|\?\.|\*?\.@|\.&|\.{1,2}(?!\.)|\.{2}<?(?=\w)|->|\?:|[-+]{1,2}|!|<=>|>{1,3}|<{1,2}|={1,2}|&{1,2}|\|{1,2}|\?|\*{1,2}|\/|\^|%)/",
                "lookbehind" => true
            ],
            'punctuation' => "/\.+|[{}[\];(),:$]/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('groovy', [
           'shebang' => [
               "pattern" => "/#!.+/",
               "alias" => 'comment'
           ]
        ], 'string');

        $this->insertBefore('groovy', [
            'spock-block' => "/\b(setup|given|when|then|and|cleanup|expect|where):/"
        ], 'punctuation');

        $this->insertBefore('groovy', [
            'annotation' => [
                "pattern" => "/(^|[^.])@\w+/",
                "lookbehind" => true
            ]
        ], 'function');

         $this->addHook('wrap', 'groovy-wrap',function(&$env) {
             if ($env['language'] === 'groovy' && $env['type'] === 'string') {
                 $text = $env['content'][0]->nodeValue; //Verify this condition
                 $delimiter = $text[0];
                if ($delimiter !== "'") {
                    $pattern = ($delimiter === '$') ? "/([^\\$])(\\$(\{.*?\}|[\w\.]+))/" : "/([^\\\\])(\\$(\{.*?\}|[\w\.]+))/";
                    $env['content'] = $this->highlight($text, [
                        'expression' => [
                            "pattern" => $pattern,
                            "lookbehind" => true,
                            "inside" => $this->getDefinition('groovy')
                        ]
                    ], 'groovy');
                    $env['classes'][] = ($delimiter === "/") ? 'regex' : 'gstring';
                }
             }
         });
    }
}
