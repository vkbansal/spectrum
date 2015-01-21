<?php
/**************************************************************
 * Change Log Page
 *************************************************************/
$txt = file_get_contents(__DIR__.'/../../prism.php/CHANGELOG.md');
$txt = $mark->text($txt);
$txt = $twig->render('index.twig', ['content'=> $txt, 'active' => 'changelog', 'base' => $base]);
$console->out("<light_green>Building</light_green> <bold><light_cyan>Change Log<light_cyan></bold>");
$txt = $prism->highlightHTML($txt);
file_put_contents(__DIR__.'/../changelog.html', $txt);
