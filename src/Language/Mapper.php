<?php
namespace VKBansal\Prism\Language;

class Mapper {


    public static function  getDefinitionClasses()
    {
        $classesBefore = get_declared_classes();

        $pattern = __DIR__."/../Components/Definition/*.php";
        $files = glob($pattern);

        foreach ($files as $file) {
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

    public static function getMap()
    {
        $definitions = self::getDefinitionClasses();

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
        return [ $map, $aliasesMap, $defaults];
    }
}
