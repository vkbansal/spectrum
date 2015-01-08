<?php
namespace VKBansal\Prism\Language;
use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Abstract class for Template language definitions
 * @package VKBansal\Prism\Language\AbstractTemplateDefinition
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractTemplateDefinition extends AbstractDefinition
{
    /**
     * Regex for template delimeter
     * for example for php it's <?php ?>
     * for handlebars it's {{{ }}} and {{ }}
     * @var string
     */
    protected $delimiterRegex;
    
    /**
     * Placeholder beigns with
     * @var string
     */
    protected $placeholderStart;
    
    /**
     * Placeholder ends with
     * @var string
     */
    protected $placeholderEnd;
    
    /**
     * Placeholder Regex
     * @var string
     */
    protected $placeholderRegex;

    /**
     * Grammar Name
     * @var string
     */
    protected $grammarName;
    
    /**
     * Template setup
     */
    abstract public function templateSetup();

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->templateSetup();
         $markup = $this->prism->hasDefinition('markup');
        
        if ($markup) {

            $delimiter = $this->delimiterRegex;
            $start = $this->placeholderStart;
            $end = $this->placeholderEnd;
            $grammarName = $this->grammarName;
            $placeholder = $this->placeholderRegex;

            $this->prism->addHook('before.highlight', function (&$env) use ($delimiter, $start, $end, $grammarName) {
                if ($env['language'] !== $grammarName) {
                    return;
                }

                $env['tokenStack'] = [];

                $env['backupCode'] = $env['code'];
                $env['code'] = preg_replace_callback($delimiter, function ($match) use (&$env, $start, $end) {
                    $env['tokenStack'][] = $match[0];

                    return $start.count($env['tokenStack']).$end;
                }, $env['code']);
            });

            // Restore env.code for other plugins (e.g. line-numbers)
            $this->prism->addHook('before.insert', function (&$env) use ($grammarName) {
                if ($env['language'] === $grammarName) {
                    $env['code'] = $env['backupCode'];
                    unset($env['backupCode']);
                }
            });

            // Re-insert the tokens after highlighting
            // and highlight them with defined grammar
            $this->prism->addHook('after.highlight', function (&$env) use ($grammarName, $placeholder) {
                if ($env['language'] !== $grammarName) {
                    return;
                }

                $elements =& $env['element'];
                $length = $elements->childNodes->length;

                for ($i = 0; $i < $length; $i++) {
                    $element = $elements->childNodes->item($i);
                    preg_replace_callback($placeholder, function ($matches) use (&$env, &$element, $grammarName) {
                        $index = $matches[1] - 1;
                        $element->nodeValue = "";
                        $nodes = $this->highlight($env['tokenStack'][$index], $env['grammar'], $grammarName);
                        foreach ($nodes as $node) {
                            $element->appendChild($node);
                        }

                    }, $element->nodeValue);
                }
            });
        }
    }
}
