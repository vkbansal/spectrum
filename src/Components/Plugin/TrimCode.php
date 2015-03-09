<?php
namespace VKBansal\Spectrum\Components\Plugin;

use VKBansal\Spectrum\Plugin\AbstractPlugin;
use VKBansal\Spectrum\Util;

/**
 * Plugin for striping extra spaces in code tag
 * Based on https://github.com/leeoniya/preCode.js
 * @package VKBansal\Spectrum\Plugin\TrimCode
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class TrimCode extends AbstractPlugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'trim-code';
    }

    /**
     * {@inheritdoc}
     */
    public function add()
    {
        $this->addHook('before.highlight',  'trim-code', function (&$env) {
            $elem =& $env['element'];
            $pre = $elem->parentNode;

            if (!Util::isPre($pre) || $pre->getAttribute('data-trim') === "false") {
                return false;
            }

            $code = $env['code'];
            $code = preg_replace("/^[\\r\\n]+/", "", $code);
            $code = preg_replace("/\s+$/", "", $code);

            if (preg_match("/^\S/m", $code)) {
                return false;
            }

            $min  = 1e3;
            preg_match_all("/^[\\t\s]+/m", $code, $matches);

            foreach ($matches[0] as $match) {
                if (strlen($match) < $min) {
                    $min = strlen($match);
                    $pattern = $match;
                }
            }

            if ($min != 1e3) {
                $code = preg_replace("/^{$pattern}/m", "", $code);
            }
            $env['code'] = $code;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function remove()
    {
        $this->removeHook('before.highlight', 'trim-code');
    }
}
