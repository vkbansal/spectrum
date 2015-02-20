<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractTemplateDefinition;

/**
 * PHP definition
 * @package VKBansal\Spectrum\Definition\Php
 * @version 0.3.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Php extends AbstractTemplateDefinition
{

    /**
     * {@inheritdoc}
     */
    protected $delimiterRegex = "/(?:<\?php|<\?)[\w\W]*?(?:\?>)/i";

    /**
     * {@inheritdoc}
     */
    protected $placeholder = "{{{PHP~}}}";

    /**
     * {@inheritdoc}
     */
    protected static $name = 'php';

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
            'keyword' => "/\b(and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i",
            'constant'=> "/\b[A-Z0-9_]{2,}\b/",
            'comment'=> [
                "pattern" => "/(^|[^\\\\])(\/\*[\w\W]*?\*\/|(^|[^:])(\/\/|#).*?(\\r?\\n|$))/",
                "lookbehind" => true
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function templatesetup()
    {
        $this->insertBefore('php', [
            'delimiter'=> "/(\?>|<\?php|<\?)/i",
            'variable'=> "/(\\$\w+)\b/i",
            'package'=> [
                "pattern" => "/(\\\\|namespace\s+|use\s+)[\w\\\\]+/",
                "lookbehind"=> true,
                "inside" => [
                    "punctuation" => "/\\\\/"
                ]
            ]
        ], 'keyword');

        // Must be defined after the function pattern
        $this->insertBefore('php', [
            'property' => [
                "pattern"=> "/(->)[\w]+/",
                "lookbehind" => true
            ]
        ], 'operator');

        // Add HTML support for the markup language
        // Add the rules before all others
        $this->insertBefore('php', [
            'markup'=> [
                "pattern"=> "/<[^?]\/?(.*?)>/",
                "inside"=> $this->getDefinition('markup')
            ],
            'php'=> "/\{\{\{PHP[0-9]+\}\}\}/"
        ], 'comment');

        //PHP Extras
        $this->insertBefore('php', [
            'this' => '/\\$this/',
            'global'=> '/\\$_?(GLOBALS|SERVER|GET|POST|FILES|REQUEST|SESSION|ENV|COOKIE|HTTP_RAW_POST_DATA|argc|argv|php_errormsg|http_response_header)/',
            'scope'=> [
                "pattern" => "/\b[\w\\\\]+::/",
                "inside"=> [
                    "keyword"=> "/(static|self|parent)/",
                    "punctuation"=> "/(::|\\\\)/"
                ]
            ]
        ], 'variable');
    }
}
