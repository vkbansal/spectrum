<?php

require __DIR__."/../prism.php/vendor/autoload.php";

use Symfony\Component\Finder\Finder;
use VKBansal\Prism\Prism;
use VKBansal\Prism\Plugin;
use VKBansal\FrontMatter\Parser;

class Colors {
    private $foreground_colors = array();
    private $background_colors = array();
 
    public function __construct() {
    // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';
     
        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }
 
    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";
     
        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
        $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
        $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }
     
        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";
     
        return $colored_string;
    }
 
    // Returns all foreground color names
    public function getForegroundColors() {
       return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}

$console = new Colors();
$base = "/prism.php/";
$prism = new Prism();
$prism->loadAllDefinitions();
$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$mark = new ParsedownExtra();

/**************************************************************
 * Index page
 *************************************************************/
$txt = file_get_contents(__DIR__.'/../prism.php/README.md');
$txt = $mark->text($txt);
$txt = $twig->render('index.twig', ['content'=> $txt, 'active' => 'home', 'base' => $base]);
echo("Building Home Page\n\n");
$txt = $prism->highlightHTML($txt);
file_put_contents(__DIR__.'/index.html', $txt);


/**************************************************************
 * Code Samples page
 *************************************************************/
$finder = new Finder();
$finder->sortByName()->files()->name('*.txt')->in(__DIR__.'/samples/code/');

$data = [];
echo("Building Sample Pages\n\n");
foreach ($finder as $file) {
    $code = file_get_contents($file->getRealpath());
    $lang = $file->getBasename('.txt');
    echo $console->getColoredString("Building {$lang}\n", 'cyan');
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
    $prism = new Prism();
    $prism->loadAllDefinitions();
    switch($name){
        case 'show-language':
            $prism->addPlugin(new Plugin\ShowLanguage);
            echo $console->getColoredString("Building Plugin ShowLanguage\n", 'cyan');
            break;
        case 'line-numbers':
            $prism->addPlugin(new Plugin\LineNumbers);
            echo $console->getColoredString("Building Plugin LineNumbers\n", "cyan");
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
