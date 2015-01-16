<?php
use Symfony\Component\Finder\Finder;
use VKBansal\FrontMatter\Parser;
use VKBansal\Prism\Components\Plugin;
/**************************************************************
 * Plugin pages
 *************************************************************/
$finder = new Finder();
$baseDir = __DIR__.'/../plugins/';
$finder->sortByName()->files()->name('*.md')->in($baseDir);

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
        case 'show-invisibles':
            $prism->addPlugin(new Plugin\ShowInvisibles);
            $console->out("<light_green>Building</light_green> <bold><light_cyan>Show Invisibles Plugin<light_cyan></bold>");
            break;
    }
    $path = $baseDir.$name;
    if(!is_dir($path)){
        mkdir($path, 0655);
    }
    $txt = file_get_contents($path.'.md');
    $txt = $mark->text($txt);
    $txt = $twig->render('index.twig', ['content' => $txt, 'active' => $name, 'base' => $base]);
    $txt = $prism->highlightHTML($txt);
    file_put_contents($path. '/index.html', $txt);
}
