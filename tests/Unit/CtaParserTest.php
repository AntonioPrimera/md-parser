<?php

use AntonioPrimera\Md\MarkdownFlavors\BasicMarkdownParser;

test('it can parse a simple call to action link', function(){
	$string = '[cta:Click here](https://example.com)';
	$parser = BasicMarkdownParser::create();
	expect($parser->parse($string))->toBe("<p><a href='https://example.com' class='cta'>Click here</a></p>");
});

test('it can parse a simple call to action link with spaces between the label and the url', function(){
	$string = '[cta:Click here]  (https://example.com)';
	$parser = BasicMarkdownParser::create();
	expect($parser->parse($string))->toBe("<p><a href='https://example.com' class='cta'>Click here</a></p>");
});

test('it can parse a simple call to action link with spaces around the label and url', function(){
	$string = '[cta: Click here  ]  ( https://example.com   )';
	$parser = BasicMarkdownParser::create();
	expect($parser->parse($string))->toBe("<p><a href='https://example.com' class='cta'>Click here</a></p>");
});