<?php
namespace VKBansal\Prism\Plugin;

use VKBansal\Prism\Plugin\PluginInterface;

trait PluggableTrait
{
    public function addPlugin(PluginInterface $plugin)
    {
        $handle = $plugin->handle();
        if (!is_callable($handle) || ! $handle instanceof \Closure) {
            throw new \Exception("handle must return a closure");
        }
        $handle = $handle->bindTo($this);
        $handle();
    }
}
