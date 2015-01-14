<?php
namespace VKBansal\Prism\Plugin;

use VKBansal\Prism\Prism;
use VKBansal\Prism\InjectorInterface;
use VKBansal\Prism\Hook\HookInterface;
/**
 * Interface for plugin for Prism
 * @package VKBansal\Prism\Plugin\PluginInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractPlugin implements InjectorInterface, HookInterface
{
    /**
     * Prism Instance
     * @var \VKBansal\Prism\Prism
     */
    protected $prism;

    /**
     * {@inheritdoc}
     */
    public function injectPrism(Prism $prism)
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
