<?php
namespace VKBansal\Spectrum\Plugin;

use VKBansal\Spectrum\Spectrum;
use VKBansal\Spectrum\InjectorInterface;
use VKBansal\Spectrum\Hook\HookInterface;
/**
 * Base class for plugin
 * @package VKBansal\Spectrum\Plugin\PluginInterface
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractPlugin implements InjectorInterface, HookInterface
{
    /**
     * Spectrum Instance
     * @var \VKBansal\Spectrum\Spectrum
     */
    protected $prism;

    /**
     * {@inheritdoc}
     */
    public function injectSpectrum(Spectrum $prism)
    {
        $this->prism = $prism;
    }

    /**
     * {@inheritdoc}
     */
    public function addHook($event, $name, \Closure $callback)
    {
        $this->prism->addHook($event, $name, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function removeHook($event, $name)
    {
        $this->prism->removeHook($event, $name);
    }

    /**
     * Name of the plugin
     * @return string
     */
    abstract public function getName();

    /**
     * Plugin definition
     * @return void
     */
    abstract public function add();

    /**
     * Plugin cleanup
     * @return void
     */
    abstract public function remove();
}
