#Plugin: Highlight Keyword
This plugin adds `keyword-*` class to allow a fine-grained control over keywords highlighting. For example, it will add a class `keyword-if` to `if` keyword.
##Usage
###PHP
```php
<?php
use VKBansal\Spectrum\Plugin\HighlightKeyword;
use VKBansal\Spectrum\Spectrum;

$highlighter = new Spectrum();
$highlighter->addPlugin(new HighlightKeyword());
```
