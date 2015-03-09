<?php
namespace VKBansal\Spectrum\Plugin;

/**
 * Trait for adding plugin functionality to Spectrum
 * @package VKBansal\Spectrum\Plugin\PluggableTrait
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
trait PluggableTrait
{
    /**
     * List of active plugins
     * @var array
     */
    protected $plugins = [];

    /**
     * Add Plugin
     * @param PluginInterface $plugin
     * @return void
     */
    public function addPlugin(AbstractPlugin $plugin)
    {
        $plugin->injectSpectrum($this);
        $this->plugins[$plugin->getName()] = $plugin;
        $plugin->add();
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
            $this->plugins[$name]->remove();
            unset($this->plugins[$name]);
        } else {
            throw new PluginNotFoundException;
        }
    }

    public function resetPlugins()
    {
        foreach ($this->plugins as $name => $plugin) {
            $this->removePlugin($name);
        }
    }
}
