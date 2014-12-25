<?php
namespace VKBansal\Prism\Plugin;

use VKBansal\Prism\Plugin\PluginInterface;

trait PluggableTrait
{
    protected $plugins = [];

    public function addPlugin(PluginInterface $plugin)
    {
        $handle = $plugin->handle();
        if (!is_callable($handle) || ! $handle instanceof \Closure) {
            throw new PluginException("Plugin handle must return a closure");
        }
        $handle = $handle->bindTo($this);
        list($hook, $name) = $handle();

        if (!is_string($hook)) {
            throw new PluginException("The closure must return the return value from hook");
        }

        if (!is_string($name)) {
            throw new PluginException("Plugin must have name");
        }

        $this->plugins[$name] = $hook;
    }

    public function removePlugin($name)
    {
        if (isset($this->plugins[$name])) {
            $this->removeHook($this->plugins[$name], $name);
        } else {
            throw new PluginNotFoundException;
        }
    }

    abstract function removeHook($name, $refer = null);
}
