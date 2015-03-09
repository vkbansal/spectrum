<?php
namespace VKBansal\Spectrum\Language;

/**
 * Language class mapper
 * @package VKBansal\Spectrum\Language\Mapper
 * @version 0.4.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Mapper {

    /**
     * Get language definition classes
     * @return array
     */
    public static function getDefinitionClasses()
    {
        $pattern = __DIR__."/../Components/Definition/*.php";
        $files = glob($pattern);

        //Since we are using PSR-4, we can safely prepend namespace
        return array_map(function($file){
            return "VKBansal\\Spectrum\\Components\\Definition\\".basename($file, ".php");
        }, $files);
    }

    /**
     * Get Mapping of language name and its class
     * @return array [Map, Aliases, Default languages]
     */
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
