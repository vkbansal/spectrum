<?php
namespace VKBansal\Prism\Components\Plugin;

use VKBansal\Prism\Plugin\AbstractPlugin;

/**
 * Plugin for highlighting keywords by adding 'keyword-*' class
 * @package VKBansal\Prism\Components\Plugin\HighlightKeyword
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class HighlightKeyword extends AbstractPlugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'highlight-keyword';
    }

    /**
     * {@inheritdoc}
     */
    public function add()
    {
        $this->addHook('wrap',  'highlight-keyword', function (&$env) {
            if ($env['type'] !== 'keyword') {
                return false;
            }
            $class = "keyword-".$env['content'][0]->nodeValue;
            $env['classes'][] = $class;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function remove()
    {
        $this->removeHook('wrap', 'highlight-keyword');
    }
}
