#Plugin: Show Language
Display the highlighted language in code blocks (inline code does not show the label).
##Usage
###PHP
```php
<?php
use VKBansal\Prism\AssetManger;
use VKBansal\Prism\Plugin\ShowLanguage;
use VKBansal\Prism\Prism;

$manger = new AssetManager;
$manager->addPlugin(new ShowLanguage());
$prism = new Prism($manager);
```

###CSS
Following css must be included in order to make the badge visible.

```css
pre[class*='language-'] {
	position: relative;
}

pre[class*='language-'] > code[data-language]::before {
	content: attr(data-language);
	color: black;
	background-color: #CFCFCF;
	display: inline-block;
	position: absolute;
	top: 0;
	right: 0;
	font-size: 0.9em;
	border-radius: 0 0 0 5px;
	padding: 0 0.5em;
	text-shadow: none;
}
```
