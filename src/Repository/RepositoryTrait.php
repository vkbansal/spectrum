<?php
namespace VKBansal\Prism\Repository;

use VKBansal\Prism\Hook\HookableTrait;

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
     * @var [type]
     */
    protected $defaults = [];

    /**
     * {@inheritdoc}
     */
    public function loadDefinition($language)
    {
        $language = $this->resolveAlias($language);

        if (isset($this->languages[$language])) {
            return;
        }
        
        if (isset($this->map[$language])) {
            $class = $this->map[$language];
            $def = new $class($this);
            $this->languages[$language] = $def->definition();
            $def->setup();
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
     * {@inheritdoc}
     */
    public function &referDefinition($language = null)
    {
        $language = $this->resolveAlias($language);

        if (is_null($language)) {
            return $this->languages;
        }

        $this->loadDefinition($language);

        if (isset($this->languages[$language])) {
            return $this->languages[$language];
        }

        $segments = explode('.', $language);

        $root =& $this->languages[array_shift($segments)];

        foreach ($segments as $segment) {
             $root =& $root[$segment];
        }
        return $root;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($language = null)
    {
        $language = $this->resolveAlias($language);

        if (is_null($language)) {
            return $this->languages;
        }

        $this->loadDefinition($language);

        if (isset($this->languages[$language])) {
            return $this->languages[$language];
        }

        $segments = explode('.', $language);

        $root = $this->languages[array_shift($segments)];

        foreach ($segments as $segment) {
             $root = $root[$segment];
        }
        
        return $root;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefinition($language)
    {
        return isset($this->languages[$language]);
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
}
