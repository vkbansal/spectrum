<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * C definition
 * @package VKBansal\Spectrum\Definition\CLang
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class CLang extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'c';

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
            // allow for c multiline strings
            'string'=> "/(\"|')([^\\n\\\\\\g{1}]|\\\\.|\\\\\\r*\\n)*?\\g{1}/",
            'keyword'=> "/\\b(asm|typeof|inline|auto|break|case|char|const|continue|default|do|double|else|enum|extern|float|for|goto|if|int|long|register|return|short|signed|sizeof|static|struct|switch|typedef|union|unsigned|void|volatile|while)\\b/",
            'operator'=> "/[-+]{1,2}|!=?|<{1,2}=?|>{1,2}=?|\\->|={1,2}|\\^|~|%|&{1,2}|\\|?\\||\\?|\\*|\\//"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('c', [
            // property class reused for macro statements
            'property'=> [
                // allow for multiline macro definitions
                // spaces after the # character compile fine with gcc
                "pattern"=> "/((^|\\n)\\s*)#\\s*[a-z]+([^\\n\\\\]|\\\\.|\\\\\\r*\\n)*/i",
                "lookbehind"=> true,
                "inside"=> [
                    // highlight the path of the include statement as a string
                    'string'=> [
                        "pattern"=> "/(#\\s*include\\s*)(<.+?>|(\"|')(\\\\?.)+?\\g{3})/",
                        "lookbehind"=> true,
                    ]
                ]
            ]
        ], 'string');

        $lang =& $this->getDefinition('c');
        unset($lang['boolean']);
        unset($lang['class-name']);
    }
}
