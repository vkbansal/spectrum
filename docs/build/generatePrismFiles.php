<?php

require __DIR__."/../../../vendor/autoload.php";

use Symfony\Component\Finder\Finder;
use VKBansal\Prism\Prism;

$prism = Prism::getInstance();
$prism->addLanguages(['markup', 'css', 'javascript']);
$finder = new Finder();
$finder->files()->name('*.html')->in(__DIR__.'/../output/');

foreach ($finder as $file) {
    
    $lang = $file->getBasename('.html');
    
    $content = file_get_contents($file->getRealpath());

    $prism->setHTML($content, false)->highlightAll();
    
    $newContent = $prism->getHTML();
    
    file_put_contents(__DIR__.'/prismed-php/'.$lang.'.html', $newContent);
}

