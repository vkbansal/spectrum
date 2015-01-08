<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Objective-C definition
 * @package VKBansal\Prism\Definition\ObjectiveC
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ObjectiveC extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'objectivec';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('c', [
            'keyword' => "/(\b(asm|typeof|inline|auto|break|case|char|const|continue|default|do|double|else|enum|extern|float|for|goto|if|int|long|register|return|short|signed|sizeof|static|struct|switch|typedef|union|unsigned|void|volatile|while|in|self|super)\b)|((?=[\w|@])(@interface|@end|@implementation|@protocol|@class|@public|@protected|@private|@property|@try|@catch|@finally|@throw|@synthesize|@dynamic|@selector)\b)/",
            "string" => "/(?:(\"|')([^\\n\\\\\g{1}]|\\\\.|\\\\\\r*\\n)*?\g{1})|(@\"([^\\n\\\\\"]|\\\\.|\\\\\\r*\\n)*?\")/",
            "operator" => "/[-+]{1,2}|!=?|<{1,2}=?|>{1,2}=?|\->|={1,2}|\^|~|%|&{1,2}|\|?\||\?|\*|\/|@/"
        ]);
    }
}
