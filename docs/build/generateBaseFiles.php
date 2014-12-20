<?php

require __DIR__."/../../vendor/autoload.php";

use Symfony\Component\Finder\Finder;
use VKBansal\Prism\Util;

$base = file_get_contents(__DIR__.'/../base.html');

$finder = new Finder();
$finder->files()->name('*.txt')->in(__DIR__.'/../samples/');

foreach ($finder as $file) {
    
    $lang = $file->getBasename('.txt');
    
    $content = file_get_contents($file->getRealpath());
    
    $newContent = preg_replace_callback("/\{\{\s*(.+?)\s*\}\}/", function($matches) use ($lang, $content)
    {
        return isset($$matches[1]) ? Util::encodeHTML($$matches[1]) : $matches[0];
    }, $base);
    
    file_put_contents(__DIR__.'/../output/'.$lang.'.html', $newContent);
}

