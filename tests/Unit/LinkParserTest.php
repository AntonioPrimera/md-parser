<?php

use AntonioPrimera\Md\InlineParsers\LinkParser;

beforeEach(function () {
	$this->parser = new LinkParser();
});

it('parses internal links without classes', function () {
	$text = '[Internal Link](internal/page)';
	$expected = '<a href="internal/page">Internal Link</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses external links with target=_blank', function () {
	$text = '[External Link](http://example.com)';
	$expected = '<a href="http://example.com" target="_blank">External Link</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses links with classes', function () {
	$text = '[Link with Class](http://example.com){class1 class2}';
	$expected = '<a href="http://example.com" target="_blank" class="class1 class2">Link with Class</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses email links', function () {
	$text = '[Email Me](mailto:example@example.com)';
	$expected = '<a href="mailto:example@example.com">Email Me</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses phone links', function () {
	$text = '[Call Me](+12 345-67.890)';
	$expected = '<a href="tel:001234567890">Call Me</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses links with mixed content', function () {
	$text = '[Mixed Content](http://example.com){class1 class2}';
	$expected = '<a href="http://example.com" target="_blank" class="class1 class2">Mixed Content</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

it('parses links with special characters in label', function () {
	$text = '[Special *Characters*](http://example.com)';
	$expected = '<a href="http://example.com" target="_blank">Special *Characters*</a>';
	expect($this->parser->parse($text))->toBe($expected);
});

test('it can parse a link with an external link and openExternalLinksInNewTab set to false', function () {
	$text = '[label](https://example.com)';
	$this->parser->setConfig('openExternalLinksInNewTab', false);
	expect($this->parser->parse($text))->toBe("<a href=\"https://example.com\">label</a>");
});

test('it can parse a link with label and url surrounded by spaces', function () {
	$text = '[ label with spaces  ] ( /url  )';
	expect($this->parser->parse($text))->toBe("<a href=\"/url\">label with spaces</a>");
});

it('parses a link with a special url processor', function () {
	$text = '[Internal Link](/page)';
	$this->parser->setConfig('urlProcessor', fn($url) => 'https://example.com' . $url);
	$this->parser->setConfig('openExternalLinksInNewTab', false);
	$expected = '<a href="https://example.com/page">Internal Link</a>';
	expect($this->parser->parse($text))->toBe($expected);
});