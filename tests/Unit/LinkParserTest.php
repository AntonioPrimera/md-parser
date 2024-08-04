<?php

use AntonioPrimera\Md\InlineParsers\LinkParser;

test('it can parse a simple link', function () {
	$text = '[label](/url)';
	$parser = new LinkParser();
	
	expect($parser->parse($text))->toBe("<a href='/url'>label</a>");
});

test('it can parse a link with an external link', function () {
	$text = '[label](https://example.com)';
	$parser = new LinkParser();
	
	expect($parser->parse($text))->toBe("<a href=\"https://example.com\" target=\"_blank\">label</a>");
});

test('it can parse a link with an external link and openExternalLinksInNewTab set to false', function () {
	$text = '[label](https://example.com)';
	$parser = new LinkParser(['openExternalLinksInNewTab' => false]);
	
	expect($parser->parse($text))->toBe("<a href=\"https://example.com\">label</a>");
});

test('it can parse a link with label and url surrounded by spaces', function () {
	$text = '[ label with spaces  ] ( /url  )';
	$parser = new LinkParser();
	
	expect($parser->parse($text))->toBe("<a href=\"/url\">label with spaces</a>");
});