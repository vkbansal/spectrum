<?php
/**
 * Default map for language definitions
 * @package VKBansal\Prism\Languages
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
return [
    'map' => [
        'bash'         => 'VKBansal\Prism\Languages\Definitions\Bash',
        'c'            => 'VKBansal\Prism\Languages\Definitions\CLang',
        'clike'        => 'VKBansal\Prism\Languages\Definitions\CLike',
        'coffeescript' => 'VKBansal\Prism\Languages\Definitions\CoffeeScript',
        'css'          => 'VKBansal\Prism\Languages\Definitions\CSS',
        'ini'          => 'VKBansal\Prism\Languages\Definitions\Ini',
        'java'         => 'VKBansal\Prism\Languages\Definitions\Java',
        'javascript'   => 'VKBansal\Prism\Languages\Definitions\JavaScript',
        'less'         => 'VKBansal\Prism\Languages\Definitions\Less',
        'markup'       => 'VKBansal\Prism\Languages\Definitions\Markup',
        'perl'         => 'VKBansal\Prism\Languages\Definitions\Perl',
        'php'          => 'VKBansal\Prism\Languages\Definitions\Php',
        'python'       => 'VKBansal\Prism\Languages\Definitions\Python',
        'ruby'         => 'VKBansal\Prism\Languages\Definitions\Ruby',
        'sql'          => 'VKBansal\Prism\Languages\Definitions\Sql'
    ],
    
    'aliases'=> [
        'coffee'        => 'coffeescript',
        'coffee-script' => 'coffeescript',
        'html'          => 'markup',
        'js'            => 'javascript',
        'xml'           => 'markup'
    ],

    'defaults' => [ 'markup', 'clike', 'css', 'javascript', 'php', 'bash' ]
];
