<?php
use Symfony\Component\Finder\Finder;
use VKBansal\FrontMatter\Parser;
/**************************************************************
 * Code Samples page
 *************************************************************/
$finder = new Finder();
$baseDir = __DIR__.'/../samples/';
$finder->sortByName()->files()->name('*.txt')->in($baseDir.'/code/');

$data = [];
$console->out("<light_green>Building</light_green> <bold><light_cyan>Sample Pages<light_cyan></bold>");
foreach ($finder as $file) {
    $code = file_get_contents($file->getRealpath());
    $lang = $file->getBasename('.txt');
    $console->out("<light_green>Building</light_green> <bold><light_cyan>{$lang}<light_cyan></bold>");
    $doc = Parser::parse($code);
    $meta = $doc->getConfig();
    $code = $prism->highlightText($doc->getContent(), $lang);
    $txt = $twig->render('code-partial.twig', ['meta'=> $meta, 'code' => $code]);
    file_put_contents($baseDir.'/partials/'.$lang.'.html', $txt);
    $data[] = $meta;
}

$txt = $twig->render('samples.twig', ['active' => 'samples', 'base' => $base, 'data' => $data]);
file_put_contents($baseDir.'/index.html', $txt);
