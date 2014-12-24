<?php
/**
 * Default map for language definitions
 * @package VKBansal\Prism\Repository
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
return [
    'map' => [
        'bash'         => 'VKBansal\Prism\Definition\Bash',
        'c'            => 'VKBansal\Prism\Definition\CLang',
        'clike'        => 'VKBansal\Prism\Definition\CLike',
        'coffeescript' => 'VKBansal\Prism\Definition\CoffeeScript',
        'css'          => 'VKBansal\Prism\Definition\CSS',
        'ini'          => 'VKBansal\Prism\Definition\Ini',
        'java'         => 'VKBansal\Prism\Definition\Java',
        'javascript'   => 'VKBansal\Prism\Definition\JavaScript',
        'less'         => 'VKBansal\Prism\Definition\Less',
        'markup'       => 'VKBansal\Prism\Definition\Markup',
        'perl'         => 'VKBansal\Prism\Definition\Perl',
        'php'          => 'VKBansal\Prism\Definition\Php',
        'python'       => 'VKBansal\Prism\Definition\Python',
        'ruby'         => 'VKBansal\Prism\Definition\Ruby',
        'sql'          => 'VKBansal\Prism\Definition\Sql'
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
