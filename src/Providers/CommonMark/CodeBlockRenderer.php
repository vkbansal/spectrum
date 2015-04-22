<?php
namespace VKBansal\Spectrum\Providers\CommonMark;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\HtmlRendererInterface;
use VKBansal\Spectrum\Spectrum;

class CodeBlockRenderer implements BlockRendererInterface
{
    /**
     * @param AbstractBlock $block
     * @param HtmlRendererInterface $htmlRenderer
     * @param bool $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, HtmlRendererInterface $htmlRenderer, $inTightList = false)
    {
        if (!($block instanceof FencedCode)) {
            throw new \InvalidArgumentException("Incompatible block type: ".get_class($block));
        }

        $infoWords = $block->getInfoWords();

        $attr = count($infoWords) === 0 || strlen($infoWords[0]) === 0 ? [] : [
            'class' => "language-". $htmlRenderer->escape($infoWords[0], true)
        ];

        $highlighter = new Spectrum();
        $content = $highlighter->highlightText($block->getStringContent(), $infoWords[0]);

        return new HtmlElement('pre', $attr, new HtmlElement('code', $attr, $content));
    }
}