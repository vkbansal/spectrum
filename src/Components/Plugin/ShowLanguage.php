<?php
namespace VKBansal\Prism\Components\Plugin;

use VKBansal\Prism\Plugin\AbstractPlugin;

/**
 * Plugin for showing language
 * @package VKBansal\Prism\Components\Plugin\ShowLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ShowLanguage extends AbstractPlugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'show-language';
    }

    /**
     * {@inheritdoc}
     */
    public function add()
    {
        $this->addHook('before.highlight',  'show-language', function (&$env) {
            $language = $env['language'];
            $env['element']->setAttribute('data-language', $language);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function remove()
    {
        $this->removeHook('before.highlight', 'show-language');
    }
}
