#Plugin: Show Invisibles
Display tabs and line endings.
##Usage
###PHP
```php
<?php
use VKBansal\Prism\Plugin\ShowInvisibles;
use VKBansal\Prism\Prism;

$prism = new Prism();
$prism->addPlugin(new ShowInvisibles());
```

###CSS
Following css must be included in order to make this plugin work.

```css
.token.tab:not(:empty):before,
.token.cr:before,
.token.lf:before {
	color: hsl(24, 20%, 85%);
}

.token.tab:not(:empty){
	width: 0;
}

.token.tab:not(:empty):before {
	content: '\21E5';
}

.token.cr:before {
	content: '\240D';
}

.token.crlf:before {
	content: '\240D\240A';
}
.token.lf:before {
	content: '\240A';
}
```
