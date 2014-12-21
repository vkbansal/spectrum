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
        'markup'     => 'VKBansal\Prism\Languages\Definitions\Markup',
        'clike'      => 'VKBansal\Prism\Languages\Definitions\CLike',
        'css'        => 'VKBansal\Prism\Languages\Definitions\CSS',
        'javascript' => 'VKBansal\Prism\Languages\Definitions\JavaScript',
        'php'        => 'VKBansal\Prism\Languages\Definitions\Php',
        'bash'       => 'VKBansal\Prism\Languages\Definitions\Bash',
        'c'          => 'VKBansal\Prism\Languages\Definitions\CLang',
    ],
    
    'aliases'=> [
        'html' => 'markup',
        'xml'  => 'markup',
        'js' => 'javascript'
    ],

    'defaults' => [ 'markup', 'clike', 'css', 'javascript', 'php', 'bash' ]
];
