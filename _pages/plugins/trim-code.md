#Plugin: Trim Code
This plugin is based on [preCode.js](https://github.com/leeoniya/preCode.js) by [@leeoniya](https://github.com/leeoniya)

Instead of writing this
```markup
<div>
    <pre><code>function hellWorld() {
    console.log("Hello World!");
}</code></pre>
</div>
```

Write this
```markup
<div>
    <pre><code>
    function hellWorld() {
        console.log("Hello World!");
    }
    </code></pre>
</div>
```

##Usage
This will work only for code blocks (`pre` > `code`) and not for inline code.

By default it adds works on all code blocks. In case you don't want a specific block to be trimmed, just add `data-trim="false"` to desired `pre` and the plugin will skip it.

###PHP
```php
<?php
use VKBansal\Prism\Plugin\TrimCode;
use VKBansal\Prism\Prism;

$prism = new Prism();
$prism->addPlugin(new TrimCode());
```
