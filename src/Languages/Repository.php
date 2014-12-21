<?php
namespace VKBansal\Prism\Languages;

use VKBansal\Prism\Hooks\HookInterface;

/**
 * Repository for language definitions
 * @package VKBansal\Prism\Languages\Repository
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Repository implements RepositoryInterface
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
     * Hooks container
     * @var VKBansal\Prism\Hooks\HookInterface
     */
    protected $hooks;

    /**
     * constructor
     * @param VKBansal\Prism\Hooks\HookInterface $hooks
     * @param string|null                        $path
     */
    public function __construct(HookInterface $hooks, $path = null)
    {
        $this->hooks = $hooks;

        if (is_null($path)) {
            $path = __DIR__.'/map.php';
        }

        if (file_exists($path)) {
            $data = require $path;
            $this->map = $data['map'];
            $this->aliases = $data['aliases'];
            $this->defaults = $data['defaults'];
        }
    }

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
     * Add Hook
     * @param string   $name
     * @param callable $callback
     */
    public function addHook($name, callable $callback)
    {
        $this->hooks->add($name, $callback);
    }

    /**
     * Run Hooks
     * @param  string $name
     * @return void
     */
    public function runHook($name)
    {
        $this->hooks->run($name);
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
