<?php
namespace VKBansal\Spectrum\Hook;

/**
 * Interface for Hook
 * @package VKBansal\Spectrum\Hook\HookInterface
 * @version 0.5.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface HookInterface
{
    /**
     * Add a Hook
     * @param  string   $event
     * @param  string   $name
     * @param  \Closure $callback
     * @return void
     */
    public function addHook($event, $name, \Closure $callback);

    /**
     * Add a Hook
     * @param  string $event
     * @param  string $name
     * @return void
     */
    public function removeHook($event, $name);
}
