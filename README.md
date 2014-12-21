[![Latest Version](https://img.shields.io/packagist/v/vkbansal/prism.php.svg?style=flat-square)](https://packagist.org/packages/vkbansal/prism.php)
[![Software License](http://img.shields.io/badge/License-BSD--3-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/vkbansal/prism.php.svg?style=flat-square)](https://travis-ci.org/vkbansal/prism.php)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/vkbansal/prism.php.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/prism.php/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/vkbansal/prism.php.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/prism.php/?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/vkbansal/prism.php.svg?style=flat-square)](https://codeclimate.com/github/vkbansal/prism.php)
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
