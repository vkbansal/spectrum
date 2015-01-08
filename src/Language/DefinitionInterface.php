<?php
namespace VKBansal\Prism\Language;

/**
 * Common interface for asset manager and a language definition
 * @package VKBansal\Prism\DefinitionInterface
 * @version 0.1.0
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
