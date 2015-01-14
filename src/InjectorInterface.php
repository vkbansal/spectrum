<?php
namespace VKBansal\Prism;

/**
 * Interface for injecting Prism
 * @package VKBansal\Prism\DefinitionInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface InjectorInterface
{
    /**
     * Injects prism
     * @param  Prism $prism
     * @return void
     */
    public function injectPrism(Prism $prism);
}
