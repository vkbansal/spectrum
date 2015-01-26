<?php
namespace VKBansal\Prism\Language;

class Mapper {

    public static function getDefinitionClasses()
    {
        $pattern = __DIR__."/../Components/Definition/*.php";
        $files = glob($pattern);

        //Since we are using PSR-4, we can safely prepend namespace
        return array_map(function($file){
            return "VKBansal\\Prism\\Components\\Definition\\".basename($file, ".php");
        }, $files);
    }

    public static function getMap()
    {
        $definitions = static::getDefinitionClasses();

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

        return [$map, $aliasesMap, $defaults];
    }
}
