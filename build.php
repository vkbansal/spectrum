<?php

require __DIR__."/../prism.php/vendor/autoload.php";
require __DIR__."/vendor/autoload.php";


use VKBansal\Prism\Prism;
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

libxml_use_internal_errors(true);
include 'build/indexPage.php';
include 'build/samplesPage.php';
include 'build/pluginsPage.php';
include 'build/changelogPage.php';
libxml_use_internal_errors(false);
