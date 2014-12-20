#Prism.php (WIP)
This is a php port of [prism.js](https://github.com/LeaVerou/prism) syntax highlighter originally written by [@LeaVerou](http://github.com/LeaVerou).

##Requirements
- PHP >= 5.4
- libxml >= 2.6.0

##Installation
```js
{
    "require" : {
        "vkbansal/prism" : "dev-master"
    }
}
```

##Usage
```php
<?php

use VKBansal\Prism\Prism;

$prism = new Prism();
$code = $prism->highlightHTML('<html>string</html>');
echo $code;
```
