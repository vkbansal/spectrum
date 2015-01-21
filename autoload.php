<?php

spl_autoload_register(function($class){
    if (!preg_match("/^VKBansal\\\\Prism\\\\\\w+/", $class)) {
        return false;
    }
    $file = str_replace("VKBansal\Prism", "", $class);
    $file = realpath(__DIR__."/src{$file}.php");
    require_once($file);
});
