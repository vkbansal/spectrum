<?php
namespace VKBansal\Prism\Hooks;

use VKBansal\Prism\Hooks\HookInterface;

class Hooks implements HookInterface
{
    /**
     * @var array
     */
    protected $hooks = [];

    /**
     * {@inheritdoc}
     */
    public function add($name, callable $callback)
    {
        if (isset($this->hooks[$name])){
            $this->hooks[$name][] = $callback;
        } else {
            $this->hooks[$name] = [$callback];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run($name, array $env = [])
    {
        if (!isset($this->hooks[$name]) || count($this->hooks[$name]) < 1) {
            return;
        }

        for ($i = 0 ; $i < count($this->hooks[$name]); $i++) {
            call_user_func($this->hooks[$name][$i], $env);
        }
    }
}
