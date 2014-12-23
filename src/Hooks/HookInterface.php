<?php
namespace VKBansal\Prism\Hooks;

/**
 * Hooks Interface
 * @package VKBansal\Prism\Hooks\HookInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface HookInterface
{
    /**
     * Add a Hook
     * @param string   $name
     * @param callable $callback
     * @return void
     */
    public function add($name, callable $callback);

    /**
     * Run a Hook
     * @param  string $name
     * @param  array  $env
     * @return void
     */
    public function run($name, array &$env = []);
}
