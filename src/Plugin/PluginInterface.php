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
     * Name of the plugin
     * @return string
     */
    public function getName();

    /**
     * Plugin definition
     * @return void
     */
    public function add();

    /**
     * Plugin cleanup
     * @return void
     */
    public function remove();
}
