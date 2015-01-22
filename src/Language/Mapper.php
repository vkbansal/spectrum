<?php
namespace VKBansal\Prism\Language;

class Mapper {

    protected $files;

    public function __construct()
    {
        $pattern = __DIR__."/../Components/Definition/*.php";
        $this->files = glob($pattern);
    }

    public function getDefinitionClasses()
    {
        $classesBefore = get_declared_classes();

        foreach ($this->files as $file) {
            if ($filePath = realpath($file)) {
                require_once $filePath;
            }
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

            $name = $class::getName();
            $map[$name] = $class;

            if ($class::getAliases()) {
                $aliases = $class::getAliases();
                foreach ($aliases as $alias) {
                    $aliasesMap[$alias] = $name;
                }
            }

            if ($class::isDefault()) {
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
