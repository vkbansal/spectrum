<?php
namespace VKBansal\Prism\Plugin;

/**
 * Trait for adding plugin functionality to Prism
 * @package VKBansal\Prism\Plugin\PluggableTrait
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
trait PluggableTrait
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * Add Plugin
     * @param PluginInterface $plugin
     * @return void
     * @throws PluginException
     */
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

    /**
     * Remove Plugin
     * @param  string $name
     * @return void
     * @throws PluginNotFoundException
     */
    public function removePlugin($name)
    {
        if (isset($this->plugins[$name])) {
            $this->removeHook($this->plugins[$name], $name);
        } else {
            throw new PluginNotFoundException;
        }
    }

    public function resetPlugins()
    {
        foreach ($this->plugins as $name => $hook) {
            $this->removeHook($hook, $name);
        }
    }

    /**
     * Abstract method for hook
     * @param  string      $name
     * @param  string|null $refer
     * @return void
     */
    abstract function removeHook($name, $refer = null);
}
