#Spectrum (WIP)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/aa72708a-2b29-4316-aa02-febeca97970b/big.png)](https://insight.sensiolabs.com/projects/aa72708a-2b29-4316-aa02-febeca97970b)

[![Latest Version](https://img.shields.io/packagist/v/vkbansal/spectrum.svg?style=flat-square)](https://packagist.org/packages/vkbansal/spectrum)
[![Software License](http://img.shields.io/badge/License-BSD--3-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/vkbansal/spectrum.svg?style=flat-square)](https://travis-ci.org/vkbansal/spectrum)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/vkbansal/spectrum.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/spectrum/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/vkbansal/spectrum.svg?style=flat-square)](https://scrutinizer-ci.com/g/vkbansal/spectrum/?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/vkbansal/spectrum.svg?style=flat-square)](https://codeclimate.com/github/vkbansal/spectrum)

A syntax highlighter written in php. This project is inspired from [prism.js](https://github.com/LeaVerou/prism) by [@LeaVerou](http://github.com/LeaVerou).

##Requirements
- PHP >= 5.4
- libxml >= 2.6.0

##Features
- All the processing done server side. Save browser redraws and repaints that may be caused due to javascript alternatives.
- Makes highlighted code cacheable, which is not possible otherwise.
- Encourages [semantic approach](http://www.w3.org/TR/html5/text-level-semantics.html#the-code-element) of using `language-xxx` class on code blocks specified by [W3C](http://www.w3.org/).
- Very easy to define new languages. Only thing you need is a good understanding of regular expressions.
- All styling is done through CSS, with sensible class names.
- Wide browser support. Even the ancient IE6-8. If your browser supports `pre` and `code` tags and CSS, you are good to go.
- Highlights nested languages (CSS in HTML, JavaScript in HTML).

##Limitations
- Regex-based so it *will* fail on certain edge cases.
