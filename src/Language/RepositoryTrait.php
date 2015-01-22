<?php
namespace VKBansal\Prism\Language;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * Repository for language definitions
 * @package VKBansal\Prism\Repository
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
trait RepositoryTrait
{
    /**
     * Languages container
     * @var array
     */
    protected $languages = [];

    /**
     * Language map container
     * @var array
     */
    protected $map = [];

    /**
     * Language aliases container
     * @var array
     */
    protected $aliases = [];

    /**
     * Default languages to be loaded
     * @var array
     */
    protected $defaults = [];

    /**
     * Load language definition
     * @param  string $language
     * @return void
     */
    public function loadDefinition($language)
    {
        $language = $this->resolveAlias($language);

        if (isset($this->languages[$language])) {
            return;
        }

        if (isset($this->map[$language])) {
            $class = $this->map[$language];
            $def = new $class();
            $this->addLanguage($def);
        }
    }

    /**
     * Load language definitions
     * @param  array $languages
     * @return void
     */
    public function loadDefinitions(array $languages)
    {
        foreach ($languages as $language) {
            $this->loadDefinition($language);
        }
    }

    /**
     * Loads All Definitions
     * @return void
     */
    public function loadAllDefinitions()
    {
        foreach ($this->map as $key => $value) {
            $this->loadDefinition($key);
        }
    }

    /**
     * Loads Default Definitions
     * @return void
     */
    public function loadDefaultDefinitions()
    {
        foreach ($this->defaults as $key) {
            $this->loadDefinition($key);
        }
    }

    /**
     * Get language definition/reference
     * @param  string|null $language
     * @return array|null
     */
    public function &getDefinition($language = null, $default = null)
    {
        if (is_null($language)) {
            return $this->languages;
        }

        if (isset($this->languages[$language])) {
            return $this->languages[$language];
        }

        $segments = explode('.', $language);

        $root =& $this->languages;

        foreach ($segments as $segment) {
            $segment = $this->resolveAlias($segment);
            if (!is_array($root) || !isset($root[$segment])) {
                return $default;
            }
            $root =& $root[$segment];
        }
        return $root;
    }

    /**
     * Check if language definition exists
     * @param  string $language
     * @return boolean
     */
    public function hasDefinition($language)
    {
        $time = microtime(true);
        $return = $this->getDefinition($language, $time);
        return $time !== $return;
    }

    /**
     * Resolve language alias
     * @param  string $language
     * @return string
     */
    public function resolveAlias($language)
    {
        if (isset($this->aliases[$language])) {
            $language = $this->aliases[$language];
        }
        return $language;
    }

    /**
     * Add Language Definition
     * @param AbstractDefinition $language
     */
    public function addLanguage(AbstractDefinition $language)
    {
        $language->injectPrism($this);
        if ($requires = $language->requires()) {
            $this->loadDefinitions($requires);
        }
        $this->languages[$language::getName()] = $language->definition();
        $language->setup();
    }
}
