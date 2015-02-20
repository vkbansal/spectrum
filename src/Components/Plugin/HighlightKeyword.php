<?php
namespace VKBansal\Spectrum\Components\Plugin;

use VKBansal\Spectrum\Plugin\AbstractPlugin;

/**
 * Plugin for highlighting keywords by adding 'keyword-*' class
 * @package VKBansal\Spectrum\Components\Plugin\HighlightKeyword
 * @version 0.3.0
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
