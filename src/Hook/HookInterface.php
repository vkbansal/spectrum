<?php
namespace VKBansal\Prism\Hook;

/**
 * Common interface for asset manager and a language definition
 * @package VKBansal\Prism\DefinitionInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface HookInterface
{
    /**
     * Add a Hook
     * @param  string        $name
     * @param  \Closure      $callback
     * @param  string|null   $refer
     * @return array
     */
    public function addHook($name, \Closure $callback, $refer = null);
}
