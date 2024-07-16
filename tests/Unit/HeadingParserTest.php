<?php

use AntonioPrimera\CustomMarkdown\MarkdownFlavors\BasicMarkdownFlavor;
use AntonioPrimera\CustomMarkdown\MarkdownParser;
use AntonioPrimera\CustomMarkdown\NodeParsers\HeadingParser;

test('it can process a title', function () {
	$string = '#Hello World';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	
	expect($processor->parse($string))->toBe('<h2>Hello World</h2>');
});

test('it can process a title with a different base heading level', function () {
	$string = '#Hello World';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	$processor->setConfig('heading', HeadingParser::BASE_HEADING_LEVEL, 3);
	expect($processor->parse($string))->toBe('<h3>Hello World</h3>');
});

test('it can process a title with space padding around the title and around the hash', function () {
	$string = '  #  Hello World  ';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	expect($processor->parse($string))->toBe('<h2>Hello World</h2>');
});

test('it can process a title with multiple hashes', function () {
	$string = ' ### Hello World ';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	expect($processor->parse($string))->toBe('<h4>Hello World</h4>');
});

test('it can process a title with multiple hashes and a different base heading level', function () {
	$string = ' ### Hello World ';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	$processor->setConfig('heading', HeadingParser::BASE_HEADING_LEVEL, 3);
	expect($processor->parse($string))->toBe('<h5>Hello World</h5>');
});

test('it maxes out at heading level 6', function () {
	$string = ' ####### Hello World ';
	$processor = MarkdownParser::create(BasicMarkdownFlavor::create());
	expect($processor->parse($string))->toBe('<h6>Hello World</h6>');
});
