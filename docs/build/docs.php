<?php

require __DIR__."/../../vendor/autoload.php";

use Symfony\Component\Finder\Finder;
use VKBansal\Prism\Util;
use VKBansal\Prism\Prism;
use VKBansal\FrontMatter\Parser;

$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
$twig = new Twig_Environment($loader);

$finder = new Finder();
$finder->sortByName()->files()->name('*.txt')->in(__DIR__.'/../samples/');

$data = [];

$prism = new Prism();
$prism->loadAllDefinitions();

foreach ($finder as $file) {
    $code = file_get_contents($file->getRealpath());
    $lang = $file->getBasename('.txt');
    $doc = Parser::parse($code);
    $meta = $doc->getConfig();
    $meta['code'] = $prism->highlightText($doc->getContent(), $lang);
    $data[] = $meta;
}

$mark = new ParsedownExtra();
$txt = file_get_contents(__DIR__.'/../../README.md');
$txt = $mark->text($txt);
$txt = $prism->highlightHTML($txt);
$txt = $twig->render('index.twig', ['content'=> $txt]);
file_put_contents(__DIR__.'/../index.html', $txt);

$txt = $twig->render('samples.twig', ['data'=> $data]);
file_put_contents(__DIR__.'/../samples.html', $txt);
