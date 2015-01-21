#Plugin: Show Language
This plugin adds 'keyword-*' class to allow a fine-grained control over keywords highlighting. For example, it will add a class `keyword-if` to `if` keyword.
##Usage
###PHP
```php
<?php
use VKBansal\Prism\Plugin\HighlightKeyword;
use VKBansal\Prism\Prism;

$prism = new Prism();
$prism->addPlugin(new HighlightKeyword());
```
