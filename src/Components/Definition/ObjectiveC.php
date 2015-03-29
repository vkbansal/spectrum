<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Objective-C definition
 * @package VKBansal\Spectrum\Definition\ObjectiveC
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ObjectiveC extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'objectivec';

    /**
     * {@inheritdoc}
     */
    protected static $requires = ['c'];

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('c', [
            'keyword' => "/(\\b(asm|typeof|inline|auto|break|case|char|const|continue|default|do|double|else|enum|extern|float|for|goto|if|int|long|register|return|short|signed|sizeof|static|struct|switch|typedef|union|unsigned|void|volatile|while|in|self|super)\\b)|((?=[\\w|@])(@interface|@end|@implementation|@protocol|@class|@public|@protected|@private|@property|@try|@catch|@finally|@throw|@synthesize|@dynamic|@selector)\\b)/",
            "string" => "/(?:(\"|')([^\\n\\\\\\g{1}]|\\\\.|\\\\\\r*\\n)*?\\g{1})|(@\"([^\\n\\\\\"]|\\\\.|\\\\\\r*\\n)*?\")/",
            "operator" => "/[-+]{1,2}|!=?|<{1,2}=?|>{1,2}=?|\\->|={1,2}|\\^|~|%|&{1,2}|\\|?\\||\\?|\\*|\\/|@/"
        ]);
    }
}
