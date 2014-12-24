<?php
namespace VKBansal\Prism\Hook;

/**
 * Hooks Implementation.
 * @package VKBansal\Prism\Hooks\Hooks
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
trait HookableTrait
{
    /**
     * @var array
     */
    protected $hooks = [];

    /**
     * {@inheritdoc}
     */
    public function addHook($name, \Closure $callback)
    {
        $callback = $callback->bindTo($this);
        
        if (isset($this->hooks[$name])) {
            $this->hooks[$name][] = $callback;
        } else {
            $this->hooks[$name] = [$callback];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function runHook($name, array &$env = [])
    {
        if (!isset($this->hooks[$name]) || count($this->hooks[$name]) < 1) {
            return;
        }

        $count = count($this->hooks[$name]);
        for ($i = 0; $i < $count; $i++) {
            $this->hooks[$name][$i]($env);
        }
    }
}
