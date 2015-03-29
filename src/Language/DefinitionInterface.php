<?php
namespace VKBansal\Spectrum\Language;

/**
 * Common interface for Spectrum and a language definition
 * @package VKBansal\Spectrum\Language\DefinitionInterface
 * @version 0.4.2
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface DefinitionInterface
{
    /**
     * Load language definition
     * @param  string $language
     * @return void
     */
    public function loadDefinition($language);

    /**
     * Get language definition/reference
     * @param  string|null $language
     * @return array|null
     */
    public function &getDefinition($language = null, $default = null);

    /**
     * Check if language definition exists
     * @param  string $language
     * @return boolean
     */
    public function hasDefinition($language);
}
