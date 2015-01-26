#Features
- All the processing done server side. Save browser redraws and repaints that may be caused due to javascript alternatives.
- Makes highlighted code cacheable, which is not possible otherwise.
- Encourages [semantic approach](http://www.w3.org/TR/html5/text-level-semantics.html#the-code-element) of using `language-xxx` class on code blocks specified by [W3C](http://www.w3.org/).
- Very easy to define new languages. Only thing you need is a good understanding of regular expressions.
- All styling is done through CSS, with sensible class names.
- Wide browser support. Even the ancient IE6-8. If your browser supports `pre` and `code` tags and CSS, you are good to go.
- Highlights nested languages (CSS in HTML, JavaScript in HTML).

##Limitations
- Regex-based so it *will* fail on certain edge cases.
