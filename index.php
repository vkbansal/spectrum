<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="assets\css\prism-okaidia.css">
    </head>
    <body>
<?php

require '../prism.php/vendor/autoload.php';
require 'vendor/autoload.php';

use VKBansal\Prism\Prism;
use VKBansal\FrontMatter\Parser;

$h = new Prism();
$h->loadAllDefinitions();
//$h->addPlugin(new VKBansal\Prism\Components\Plugin\TrimCode);
//$h->addPlugin(new VKBansal\Prism\Components\Plugin\LineNumbers);

$lang = isset($_GET['l']) ? $_GET['l'] : 'markup';

$dir = __DIR__."/samples/code/{$lang}.txt";

if (file_exists($dir)) {
    $doc = Parser::parse(file_get_contents($dir));
    ?>
        <pre class="language-<?=$lang?>"><code class="language-<?=$lang?>"><?= $h->highlightText($doc->getContent(), $lang) ?></code></pre>
    <?php
}
?>
    </body>
</html>
