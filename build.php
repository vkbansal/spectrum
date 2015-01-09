<?php

require __DIR__."/../prism.php/vendor/autoload.php";
require __DIR__."/vendor/autoload.php";

use Symfony\Component\Finder\Finder;
use VKBansal\Prism\Prism;
use VKBansal\Prism\Components\Plugin;
use VKBansal\FrontMatter\Parser;
use League\CLImate\CLImate;

$console = new CLImate();
$base = "/prism.php/";
$prism = new Prism();
$prism->loadAllDefinitions();
$prism->loadDefinitions(['php', 'css', 'javascript']);
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$mark = new ParsedownExtra();

/**************************************************************
 * Index page
 *************************************************************/
$txt = file_get_contents(__DIR__.'/../prism.php/README.md');
$txt = $mark->text($txt);
$txt = $twig->render('index.twig', ['content'=> $txt, 'active' => 'home', 'base' => $base]);
$console->out("<light_green>Building</light_green> <bold><light_cyan>Home Page<light_cyan></bold>");
$txt = $prism->highlightHTML($txt);
file_put_contents(__DIR__.'/index.html', $txt);


/**************************************************************
 * Code Samples page
 *************************************************************/
$finder = new Finder();
$finder->sortByName()->files()->name('*.txt')->in(__DIR__.'/samples/code/');

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
    file_put_contents(__DIR__.'/samples/partials/'.$lang.'.html', $txt);
    $data[] = $meta;
}

$txt = $twig->render('samples.twig', ['active' => 'samples', 'base' => $base, 'data' => $data]);
file_put_contents(__DIR__.'/samples/index.html', $txt);



/**************************************************************
 * Plugin pages
 *************************************************************/
$finder = new Finder();
$finder->sortByName()->files()->name('*.md')->in(__DIR__.'/plugins/');

foreach ($finder as $file) {
    $name = $file->getBasename('.md');
    $prism->resetPlugins();
    switch($name){
        case 'show-language':
            $prism->addPlugin(new Plugin\ShowLanguage);
            $console->out("<light_green>Building</light_green> <bold><light_cyan>Show Language Plugin<light_cyan></bold>");
            break;
        case 'line-numbers':
            $prism->addPlugin(new Plugin\LineNumbers);
            $console->out("<light_green>Building</light_green> <bold><light_cyan>Line Numbers Plugin<light_cyan></bold>");
            break;
    }
    $path = __DIR__ . '/plugins/'.$name;
    if(!is_dir($path)){
        mkdir($path, 0655);
    }
    $txt = file_get_contents($path.'.md');
    $txt = $mark->text($txt);
    $txt = $twig->render('index.twig', ['content' => $txt, 'active' => $name, 'base' => $base]);
    $txt = $prism->highlightHTML($txt);
    file_put_contents($path. '/index.html', $txt);
}
