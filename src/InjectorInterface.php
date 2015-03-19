<?php
namespace VKBansal\Spectrum;

/**
 * Interface for injecting Spectrum
 * @package VKBansal\Spectrum\InjectorInterface
 * @version 0.4.1
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface InjectorInterface
{
    /**
     * Injects prism
     * @param  Spectrum $prism
     * @return void
     */
    public function injectSpectrum(Spectrum $prism);
}
