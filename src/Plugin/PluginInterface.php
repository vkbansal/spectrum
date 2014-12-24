<?php
namespace VKBansal\Prism\Plugin;

interface PluginInterface
{
    /**
     * Plugin definition as a closure. 
     * Closure will be bound to VKBansal\Prism\Prism.
     * @return \Closure
     */
    public function handle();
}
