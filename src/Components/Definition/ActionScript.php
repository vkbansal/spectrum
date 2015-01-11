<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * ActionScript definition
 * @package VKBansal\Prism\Definition\ActionScript
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ActionScript extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'actionscript';
    }

    /**
     * {@inheritdoc}
     */
    public function requires()
    {
        return ['javascript', 'markup'];
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {   /* Fix XML highlighting*/
        return $this->extend('javascript',  [
            'keyword' => "/\b(?:as|break|case|catch|class|const|default|delete|do|else|extends|finally|for|function|if|implements|import|in|instanceof|interface|internal|is|native|new|null|package|private|protected|public|return|super|switch|this|throw|try|typeof|use|var|void|while|with|dynamic|each|final|get|include|namespace|native|override|set|static)\b/",
            'operator' => "/(?:[+\-*\/%^]|&&?|\|\|?|<<?|>>?>?|[!=]=)=?|[=~?@]/"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->insertBefore('actionscript', [
            'xml' => [
                "pattern" => "/(^|[^.])<[\s\S]*>(?=\s*($|[\\r\\n,.;\]})<]))/",
                "inside" => [
                    "rest" => $this->getDefinition('markup')
                ]
            ]
        ], 'operator');
        
        $actionscript =& $this->getDefinition('actionscript');
        $actionscript['class-name']['alias'] = 'function';
    }
}
