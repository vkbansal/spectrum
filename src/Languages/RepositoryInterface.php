<?php
namespace VKBansal\Prism\Languages;

/**
 * Repository Interface
 * @package VKBansal\Prism\Languages\RepositoryInterface
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
interface RepositoryInterface
{
    /**
     * Loads language definition
     * @param  string $language
     * @return void
     */
    public function loadDefinition($language);

    /**
     * Get reference to definition
     * @param  string|null $language
     * @return array
     */
    public function &referDefinition($language = null);

    /**
     * Get language definition
     * @param  string|null $language
     * @return array
     */
    public function getDefinition($language = null);

    /**
     * Checks if definition is loaded
     * @param  string  $language
     * @return boolean
     */
    public function hasDefinition($language);
}
