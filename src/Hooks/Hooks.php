<?php
namespace VKBansal\Prism\Hooks;

use VKBansal\Prism\Hooks\HookInterface;

/**
 * Hooks Implementation.
 * @package VKBansal\Prism\Hooks\Hooks
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
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
        if (isset($this->hooks[$name])) {
            $this->hooks[$name][] = $callback;
        } else {
            $this->hooks[$name] = [$callback];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run($name)
    {
        $arguments = func_get_args();
        $name = array_shift($arguments);

        if (!isset($this->hooks[$name]) || count($this->hooks[$name]) < 1) {
            return;
        }

        $count = count($this->hooks[$name]);
        for ($i = 0; $i < $count; $i++) {
            call_user_func_array($this->hooks[$name][$i], $arguments);
        }
    }
}
