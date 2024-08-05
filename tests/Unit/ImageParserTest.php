<?php

use AntonioPrimera\Md\InlineParsers\ImageParser;

beforeEach(function () {
	$this->parser = new ImageParser();
});

it('parses simple image tags', function () {
	$text = '![Alt Text](http://example.com/image.jpg)';
	$expected = '<img src="http://example.com/image.jpg" alt="Alt Text">';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses image tags with classes', function () {
	$text = '![Alt Text](http://example.com/image.jpg){class1 class2, class3}';
	$expected = '<img src="http://example.com/image.jpg" alt="Alt Text" class="class1 class2 class3">';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses image tags with special characters in alt text', function () {
	$text = '![Special *Characters*](http://example.com/image.jpg)';
	$expected = '<img src="http://example.com/image.jpg" alt="Special *Characters*">';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses image tags with alt text and url surrounded by spaces', function () {
	$text = '![ Alt Text with spaces  ] ( http://example.com/image.jpg  ) { class1 }';
	$expected = '<img src="http://example.com/image.jpg" alt="Alt Text with spaces" class="class1">';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses multiple image tags in the same text', function () {
	$text = '![First Image](http://example.com/first.jpg) and ![Second Image](http://example.com/second.jpg)';
	$expected = '<img src="http://example.com/first.jpg" alt="First Image"> and <img src="http://example.com/second.jpg" alt="Second Image">';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses an image tag with a special url processor', function () {
	$text = '![Alt Text](/image.jpg)';
	$this->parser->setConfig('urlProcessor', fn($url) => 'https://example.com' . $url);
	$expected = '<img src="https://example.com/image.jpg" alt="Alt Text">';
	expect($this->parser->parse($text))->toBe($expected);
});