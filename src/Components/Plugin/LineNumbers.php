<?php
namespace VKBansal\Prism\Components\Plugin;

use VKBansal\Prism\Plugin\PluginInterface;

/**
 * Plugin for showing line numbers in code blocks
 * @package VKBansal\Prism\Plugin\LineNumbers
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class LineNumbers implements PluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        return function () {
            return $this->addHook('after.highlight', function (&$env) {
                $elem =& $env['element'];
                $pre = $elem->parentNode;

                if (preg_match("/pre/i", $pre->nodeName) !== 1 || $pre->getAttribute('data-line-numbers') === "false") {
                    return false;
                }

                $className = $pre->getAttribute('class');
                $className .= " line-numbers";
                $pre->setAttribute('class', $className);

                $lineNum = count(explode("\n", $env['code']));
                $document = $elem->ownerDocument;
                $linesNumWrapper = $document->createElement('span');
                $linesNumWrapper->setAttribute('class', 'line-numbers-rows');

                for ($i = 1; $i <= $lineNum; $i++) {
                    $lines = $document->createElement('span');
                    $linesNumWrapper->appendChild($lines);
                }

                if ($pre->getAttribute('data-start') !== "") {
                    $start = ((int) $pre->getAttribute('data-start')) - 1;
                    $pre->setAttribute('style', "counter-reset: linenumber {$start}");
                }

                $elem->appendChild($linesNumWrapper);
            }, 'line-numbers');
        };
    }
}
