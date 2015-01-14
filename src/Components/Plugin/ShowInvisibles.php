<?php
namespace VKBansal\Prism\Components\Plugin;

use VKBansal\Prism\Plugin\AbstractPlugin;

/**
 * Plugin for showing tab and new line characters
 * @package VKBansal\Prism\Components\Plugin\ShowLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class ShowInvisibles extends AbstractPlugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'show-invisibles';
    }

    /**
     * {@inheritdoc}
     */
    public function add()
    {
        $this->addHook('before.highlight', 'show-invisibles', function (&$env) {
            $grammar =& $env['grammar'];
            $grammar['tab'] = "/\\t/"; // '\u21E5'
            $grammar['crlf'] = "/\\r\\n/"; // '\u240D'
            $grammar['lf'] = "/\\n/"; // '\u240A'
            $grammar['cr'] = "/\\r/"; // '\u240D'
        });
    }

    /**
     * {@inheritdoc}
     */
    public function remove()
    {
        $this->removeHook('before.highlight', 'show-invisibles');
    }
}
