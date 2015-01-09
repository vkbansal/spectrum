<?php
namespace VKBansal\Prism\Language;

use Symfony\Component\Finder\Finder;

class Mapper {

    protected $finder;

    protected $definitions;

    public function __construct()
    {
        $this->definitions = __DIR__."/../Components/Definition";
        $this->finder = new Finder();
    }

    public function getDefinitionClasses()
    {
        $classesBefore = get_declared_classes();
        $this->finder->files()->in($this->definitions)->name("/\w+?\.php/");

        foreach ($this->finder as $file) {
            $filePath = $file->getRealPath();
            require_once $filePath;
        }

        $classesAfter = get_declared_classes();
        $newClasses = array_diff( $classesAfter, $classesBefore);

        return array_filter($newClasses, function($class){
            return preg_match("/^VKBansal\\\\Prism\\\\Components\\\\Definition\\\\\\w+/", $class);
        });
    }

    public function getMap()
    {
        $definitions = $this->getDefinitionClasses();

        $map = [];
        $aliasesMap = [];
        $defaults = [];

        foreach ($definitions as $class) {
            $def = new $class();

            $name = $def->getName();
            $map[$name] = $class;

            if ($def->aliases()) {
                $aliases = $def->aliases();
                $aliases = is_array($aliases) ? $aliases : [$aliases];
                foreach ($aliases as $alias) {
                    $aliasesMap[$alias] = $name;
                }
            }

            if ($def->isDefault()) {
                $defaults[] = $name;
            }
        }
        return ['map' => $map, 'aliases' => $aliasesMap, 'defaults' => $defaults];
    }

    public function saveMap($path, $map = null)
    {
        if (is_null($map)) {
            $map = $this->getMap();
        }
        file_put_contents($path, json_encode($map, JSON_PRETTY_PRINT));
    }
}
