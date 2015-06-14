<?php
namespace VKBansal\Spectrum\Components\Plugin;

use VKBansal\Spectrum\Plugin\AbstractPlugin;
use VKBansal\Spectrum\Util;

/**
 * Plugin for showing line numbers in code blocks
 * @package VKBansal\Spectrum\Components\Plugin\LineNumbers
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class LineNumbers extends AbstractPlugin
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'line-numbers';
    }

    /**
     * {@inheritdoc}
     */
    public function add()
    {
        $this->addHook('after.highlight', 'line-numbers', function (&$env) {
            $elem =& $env['element'];
            $pre = $elem->parentNode;

            if (!Util::isPre($pre) || $pre->getAttribute('data-line-numbers') === "false") {
                return false;
            }

            Util::addClass($pre, 'line-numbers');

            $lineNum = count(explode("\n", $env['code']));
            $document = $elem->ownerDocument;
            $linesNumWrapper = $document->createElement('span');
            Util::addClass($linesNumWrapper, 'line-numbers-rows');

            for ($i = 1; $i <= $lineNum; $i++) {
                $lines = $document->createElement('span');
                $linesNumWrapper->appendChild($lines);
            }

            if ($pre->getAttribute('data-start') !== "") {
                $start = ((int) $pre->getAttribute('data-start')) - 1;
                $pre->setAttribute('style', "counter-reset: linenumber {$start}");
            }

            $elem->appendChild($linesNumWrapper);
        });
    }

    public function remove()
    {
        $this->removeHook('after.highlight', 'line-numbers');
    }
}
