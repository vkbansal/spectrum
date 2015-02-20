<?php
namespace VKBansal\Spectrum\Language;
use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Abstract class for Template language definitions
 * @package VKBansal\Spectrum\Language\AbstractTemplateDefinition
 * @version 0.3.0
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
     * Placeholder for the code
     * @var string
     */
    protected $placeholder;

    /**
     * Placeholder for the code
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
     *
     */
    public function __construct()
    {
        $this->placeholderRegex = "/".str_replace("~", "([0-9]+)", preg_quote($this->placeholder))."/";
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        $this->templateSetup();
        $markup = $this->prism->hasDefinition('markup');

        if ($markup) {

            $grammarName = $this->getName();
            $delimiter = $this->delimiterRegex;
            $placeholder = $this->placeholder;
            $regex = $this->placeholderRegex;

            $this->prism->addHook('before.highlight', $grammarName.'-replace-token', function (&$env) use ($delimiter, $placeholder, $grammarName) {
                if ($env['language'] !== $grammarName) {
                    return;
                }

                $env['tokenStack'] = [];

                $env['backupCode'] = $env['code'];
                $env['code'] = preg_replace_callback($delimiter, function ($match) use (&$env, $placeholder) {
                    $env['tokenStack'][] = $match[0];

                    return str_replace("~", count($env['tokenStack']), $placeholder);
                }, $env['code']);
            });

            // Restore env.code for other plugins (e.g. line-numbers)
            $this->prism->addHook('before.insert', $grammarName.'-restore-code', function (&$env) use ($grammarName) {
                if ($env['language'] === $grammarName) {
                    $env['code'] = $env['backupCode'];
                    unset($env['backupCode']);
                }
            });

            // Re-insert the tokens after highlighting
            // and highlight them with defined grammar
            $this->prism->addHook('after.highlight', $grammarName.'-insert-token', function (&$env) use ($grammarName, $regex) {
                if ($env['language'] !== $grammarName) {
                    return;
                }

                $elements =& $env['element'];
                $length = $elements->childNodes->length;

                for ($i = 0; $i < $length; $i++) {
                    $element = $elements->childNodes->item($i);
                    preg_replace_callback($regex, function ($matches) use (&$env, &$element, $grammarName) {
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
