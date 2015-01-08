<?php
namespace VKBansal\Prism\Plugin;

/**
 * Plugin for showing language
 * @package VKBansal\Prism\Plugin\ShowLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ShowLanguage implements PluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        return function () {
            return $this->addHook('before.highlight', function (&$env) {
                $language = $env['language'];
                $env['element']->setAttribute('data-language', $language);
            }, 'show-language');
        };
    }
}
