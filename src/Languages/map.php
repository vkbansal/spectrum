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
        'bash'       => 'VKBansal\Prism\Languages\Definitions\Bash',
        'c'          => 'VKBansal\Prism\Languages\Definitions\CLang',
        'clike'      => 'VKBansal\Prism\Languages\Definitions\CLike',
        'css'        => 'VKBansal\Prism\Languages\Definitions\CSS',
        'javascript' => 'VKBansal\Prism\Languages\Definitions\JavaScript',
        'markup'     => 'VKBansal\Prism\Languages\Definitions\Markup',
        'php'        => 'VKBansal\Prism\Languages\Definitions\Php',
        'python'     => 'VKBansal\Prism\Languages\Definitions\Python',
        'ruby'       => 'VKBansal\Prism\Languages\Definitions\Ruby',
        'sql'        => 'VKBansal\Prism\Languages\Definitions\Sql'
    ],
    
    'aliases'=> [
        'html' => 'markup',
        'js'   => 'javascript',
        'xml'  => 'markup'
    ],

    'defaults' => [ 'markup', 'clike', 'css', 'javascript', 'php', 'bash' ]
];
