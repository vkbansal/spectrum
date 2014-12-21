[![SensioLabsInsight](https://insight.sensiolabs.com/projects/aa72708a-2b29-4316-aa02-febeca97970b/big.png)](https://insight.sensiolabs.com/projects/aa72708a-2b29-4316-aa02-febeca97970b)

[![Latest Version](https://img.shields.io/packagist/v/vkbansal/prism.php.svg?style=flat-square)](https://packagist.org/packages/vkbansal/prism.php)
[![Software License](http://img.shields.io/badge/License-BSD--3-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/vkbansal/prism.php.svg?style=flat-square)](https://travis-ci.org/vkbansal/prism.php)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/vkbansal/prism.php.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/prism.php/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/vkbansal/prism.php.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/prism.php/?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/vkbansal/prism.php.svg?style=flat-square)](https://codeclimate.com/github/vkbansal/prism.php)
#Prism.php (WIP)
This is a php port of [prism.js](https://github.com/LeaVerou/prism) syntax highlighter originally written by [@LeaVerou](http://github.com/LeaVerou).

It follows the [semantic approach](http://www.w3.org/TR/html5/text-level-semantics.html#the-code-element) specified by [W3C](http://www.w3.org/).

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

##Basic usage

```php
<?php

use VKBansal\Prism\Prism;

$prism = new Prism();
```

###Highlighting HTML
For highlighting HTML, `code` blocks must have a `language-` prefixed `class` attribute. For example, if you want to highlight `HTML`, the code block must have a `language-html` class.

Prism will auto-detect the language and apply highlighting if the language definition is found.
```php
$html = <<<HTML
<html>
<head>
    <link rel="stylesheet" href="prism.css">
</head>
<body>
    <h1>Test</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore laboriosam, magni facilis accusantium officia tenetur <code>voluptatum</code> voluptatem incidunt minus, corporis vel in sed veniam architecto? Doloremque nam excepturi pariatur, harum?</p>
    <pre><code class="language-html">
    <html>
        <head>
            <title>Title goes here!</title>
        </head>
        <br>
    </html>
    </code></pre>
</body>
</html>
HTML;

echo $prism->highlightHTML($html);
```

###Highlighting Text
You can also highlight text directly, when you know the language.
```php
echo $prism->highlightText('<html>string</html>', 'html');
```
