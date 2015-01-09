<?php
namespace VKBansal\Prism\Plugin;

/**
 * Interface for plugin for Prism
 * @package VKBansal\Prism\Plugin\PluginInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface PluginInterface
{
    /**
     * Plugin definition as a closure.
     * Closure will be bound to VKBansal\Prism\Prism.
     * @return \Closure
     */
    public function handle();
}
