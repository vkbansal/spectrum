<?php
namespace VKBansal\Prism\Plugin;

class ShowLanguage implements PluginInterface
{
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
