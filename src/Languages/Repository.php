<?php
namespace VKBansal\Prism\Languages;

use VKBansal\Prism\Hooks\HookInterface;

class Repository implements RepositoryInterface
{
    /**
     * Languages container
     * @var array
     */
    protected $languages = [];

    protected $map = [];

    protected $hooks;

    /**
     * [__construct description]
     * @param [type] $dir [description]
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
        }
    }

    /**
     * Loads language definition
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
            $def = new $class($this);
            $this->languages[$language] = $def->definition();
            $def->setup();
        }
    }

    public function loadAllDefinitions()
    {
        foreach ($this->map as $key => $value) {
            $this->loadDefinition($key);
        }
    }

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

    public function hasDefinition($language)
    {
        return isset($this->languages[$language]);
    }

    public function addHook($name, callable $callback)
    {
        $this->hooks->add($name, $callback);
    }

    public function runHook($name)
    {
        $this->hooks->run($name);
    }

    protected function resolveAlias($language)
    {
        if (isset($this->aliases[$language])) {
            $language = $this->aliases[$language];
        }

        return $language;
    }
}
