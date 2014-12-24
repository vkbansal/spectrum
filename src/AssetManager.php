<?php
namespace VKBansal\Prism;

use VKBansal\Prism\Hook\HookableTrait;
use VKBansal\Prism\Repository\RepositoryTrait;
use VKBansal\Prism\Plugin\PluggableTrait;

class AssetManager
{
    use HookableTrait;
    use RepositoryTrait;
    use PluggableTrait;

    public function __construct($path = null)
    {
        if ($path === null) {
            $path = __DIR__."/Repository/map.php";
        }

        if (file_exists($path)) {
            $data = require $path;
            $this->map = $data['map'];
            $this->defaults = $data['defaults'];
            $this->aliases = $data['aliases'];
        }
    }
}
