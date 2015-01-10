<?php
namespace VKBansal\Prism\Components\Plugin;

use VKBansal\Prism\Plugin\PluginInterface;

/**
 * Plugin for showing tab and new line characters
 * @package VKBansal\Prism\Plugin\ShowLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ShowInvisibles implements PluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        return function () {
            return $this->addHook('before.highlight', function (&$env) {
                $grammar =& $env['grammar'];
                $grammar['tab'] = "/\\t/"; // '\u21E5'
                $grammar['crlf'] = "/\\r\\n/"; // '\u240D'
                $grammar['lf'] = "/\\n/"; // '\u240A'
                $grammar['cr'] = "/\\r/"; // '\u240D'
            }, 'show-invisibles');
        };
    }
}
