#Plugin: Line Numbers
Line number at the beginning of code lines.
##Usage
This will work only for code blocks (`pre` > `code`) and not for inline code.

By default it adds line numbers to all code blocks. In case you don't want a specific block to have line numbers, just add `data-line-numbers="false"` to desired `pre` and the plugin will skip it.

Optionally, you can specify the `data-start` (Number) attribute on the `pre` element to shift the line counter.
###PHP
```php
<?php
use VKBansal\Prism\AssetManger;
use VKBansal\Prism\Plugin\LineNumbers;
use VKBansal\Prism\Prism;

$manger = new AssetManager;
$manager->addPlugin(new LineNumbers());
$prism = new Prism($manager);
```

###CSS
Following css must be included in order to make this plugin work.

```css
pre.line-numbers {
	position: relative;
	padding-left: 3.8em;
	counter-reset: linenumber;
}

pre.line-numbers > code {
	position: relative;
}

.line-numbers .line-numbers-rows {
	position: absolute;
	pointer-events: none;
	top: 0;
	font-size: 100%;
	left: -3.8em;
	width: 3em; /* works for line-numbers below 1000 lines */
	letter-spacing: -1px;
	border-right: 1px solid #999;

	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;

}

	.line-numbers-rows > span {
		pointer-events: none;
		display: block;
		counter-increment: linenumber;
	}

		.line-numbers-rows > span:before {
			content: counter(linenumber);
			color: #999;
			display: block;
			padding-right: 0.8em;
			text-align: right;
		}
```
