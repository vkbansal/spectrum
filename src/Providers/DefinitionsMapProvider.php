<?php
namespace VKBansal\Prism\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use VKBansal\Prism\Language\Mapper;

class DefinitionsMapProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        list($map, $aliases, $defaults) = Mapper::getMap();

        $pimple['language-map'] = $map;
        $pimple['language-aliases'] = $aliases;
        $pimple['default-languages'] = $defaults;
    }
}
