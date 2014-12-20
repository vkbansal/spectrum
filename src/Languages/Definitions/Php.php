<?php
namespace VKBansal\Prism\Languages\Definitions;

use VKBansal\Prism\Languages\AbstractLanguage;

class Php extends AbstractLanguage
{
    public function definition()
    { 
        return $this->extend('clike', [
            'keyword' => "/\b(and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i",
            'constant'=> "/\b[A-Z0-9_]{2,}\b/",
            'comment'=> [
                "pattern" => "/(^|[^\\\\])(\/\*[\w\W]*?\*\/|(^|[^:])(\/\/|\#).*?(\r?\n|$))/",
                "lookbehind" => true
            ]
        ]);
    }

    public function setup()
    {
        $this->insertBefore('php', [
            'delimiter'=> "/(\?>|<\?php|<\?)/i",
            'variable'=> "/(\$\w+)\b/i",
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

        // Add HTML support of the markup language exists
        $markup = $this->repository->hasDefinition('markup');
        
        if ($markup) {
            /* Tokenize all inline PHP blocks that are wrapped in <?php ?>
             * This allows for easy PHP + markup highlighting
             */
            $this->repository->addHook('before-highlight', function($env) {
                /*if (env.language !== 'php') {
                    return;
                }

                env.tokenStack = [];

                env.backupCode = env.code;
                env.code = env.code.replace(/(?:<\?php|<\?)[\w\W]*?(?:\?>)/ig, function(match) {
                    env.tokenStack.push(match);

                    return '{{{PHP' + env.tokenStack.length + '}}}';
                });*/
            });

            // Restore env.code for other plugins (e.g. line-numbers)
            $this->repository->addHook('before-insert', function($env) {
                // if (env.language === 'php') {
                //     env.code = env.backupCode;
                //     delete env.backupCode;
                // }
            });

            // Re-insert the tokens after highlighting
            $this->repository->addHook('after-highlight', function($env) {
                // if (env.language !== 'php') {
                //     return;
                // }

                // for (var i = 0, t; t = env.tokenStack[i]; i++) {
                //     env.highlightedCode = env.highlightedCode.replace('{{{PHP' + (i + 1) + '}}}', Prism.highlight(t, env.grammar, 'php'));
                // }

                // env.element.innerHTML = env.highlightedCode;
            });

            // Wrap tokens in classes that are missing them
            $this->repository->addHook('wrap', function($env) {
                // if (env.language === 'php' && env.type === 'markup') {
                //     env.content = env.content.replace(/(\{\{\{PHP[0-9]+\}\}\})/g, "<span class=\"token php\">$1</span>");
                // }
            });

            // Add the rules before all others
            $this->insertBefore('php', [
                'markup'=> [
                    "pattern"=> "/<[^?]\/?(.*?)>/",
                    "inside"=> $this->repository->getDefinition('markup')
                ],
                'php'=> "/\{\{\{PHP[0-9]+\}\}\}/"
            ], 'comment');

            //PHP Extras
            $this->insertBefore('php', 'variable', [
                'this' => "/\$this/",
                'global'=> "/\$_?(GLOBALS|SERVER|GET|POST|FILES|REQUEST|SESSION|ENV|COOKIE|HTTP_RAW_POST_DATA|argc|argv|php_errormsg|http_response_header)/",
                'scope'=> [
                    "pattern" => "/\b[\w\\\\]+::/",
                    "inside"=> [
                        "keyword"=> "/(static|self|parent)/",
                        "punctuation"=> "/(::|\\\\)/"
                    ]
                ]
            ]);
        }
    }
}
