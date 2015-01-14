<?php
namespace VKBansal\Prism\Hook;

/**
 * Common interface for Prism and a language definition
 * @package VKBansal\Prism\DefinitionInterface
 * @version 0.1.0
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
