<?php
namespace VKBansal\Prism\Hooks;

interface HookInterface
{
    /**
     * Add a Hook
     * @param string   $name
     * @param callable $callback
     */
    public function add($name, callable $callback);

    /**
     * Run a Hook
     * @param  name   $name
     * @param  Node   $node
     */
    public function run($name, array $env = []);
}
