<?php
namespace VKBansal\Spectrum\Hook;

/**
 * Hooks Implementation.
 * @package VKBansal\Spectrum\Hooks\HookableTrait
 * @version 0.4.1
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
     * Add a Hook
     * @param  string        $event
     * @param  string        $name
     * @param  \Closure      $callback
     * @return void
     */
    public function addHook($event, $name, \Closure $callback)
    {
        $callback = $callback->bindTo($this);

        if (!isset($this->hooks[$event])) {
            $this->hooks[$event] = [];
        }

        $this->hooks[$event][$name] = $callback;
    }

    /**
     * Run Hook
     * @param  string $name
     * @param  array  $env
     * @return void
     */
    public function runHook($name, array &$env = [])
    {
        if (!isset($this->hooks[$name]) || count($this->hooks[$name]) < 1) {
            return;
        }

        foreach ($this->hooks[$name] as $key => $callback) {
            $callback($env);
        }
    }

    /**
     * Remove Hook
     * @param  string      $event
     * @param  string      $name
     * @return void
     */
    public function removeHook($event, $name)
    {
        unset($this->hooks[$event][$name]);
    }
}
