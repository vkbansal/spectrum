<?php
/**************************************************************
 * Index page
 *************************************************************/
$txt = file_get_contents(__DIR__.'/../index.md');
$txt = $mark->text($txt);
$txt = $twig->render('index.twig', ['content'=> $txt, 'active' => 'home', 'base' => $base]);
$console->out("<light_green>Building</light_green> <bold><light_cyan>Home Page<light_cyan></bold>");
$txt = $prism->highlightHTML($txt);
file_put_contents(__DIR__.'/../index.html', $txt);
