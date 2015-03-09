<?php
namespace VKBansal\Spectrum\Plugin;

/**
 * Interface for plugin
 * @package VKBansal\Spectrum\Plugin\PluginInterface
 * @version 0.4.0
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
