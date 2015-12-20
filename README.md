# Abandoned!

#Spectrum
A syntax highlighter written in php. This project is inspired from [prism.js](https://github.com/LeaVerou/prism) by [@LeaVerou](http://github.com/LeaVerou).

##Installation
```bash
composer require vkbansal/spectrum
```
##Requirements
- PHP >= 5.4
- [DOM extension](http://php.net/manual/en/book.dom.php)

##Basic usage

```php
<?php
use VKBansal\Spectrum\Spectrum;
$highlighter = new Spectrum();
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

echo $highlighter->highlightHTML($html);
```

For more details go to [website](https://vkbansal.github.io/spectrum)
