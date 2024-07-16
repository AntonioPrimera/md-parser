<?php
use AntonioPrimera\CustomMarkdown\MarkdownFlavors\BasicMarkdownFlavor;
use AntonioPrimera\CustomMarkdown\MarkdownParser;

test('it can split a text into paragraphs', function() {
	$parser  = new MarkdownParser(BasicMarkdownFlavor::create());
	$text = "This is the first paragraph.\n\nThis is the third paragraph.";
	$expected = "<p>This is the first paragraph.</p>\n<p></p>\n<p>This is the third paragraph.</p>";
	
	expect($parser->parse($text))->toBe($expected);
});

test('it will trim paragraphs', function() {
	$parser  = new MarkdownParser(BasicMarkdownFlavor::create());
	$text = "  This is the first paragraph.\t  \n   \n  This is the third paragraph.  \t";
	$expected = "<p>This is the first paragraph.</p>\n<p></p>\n<p>This is the third paragraph.</p>";
	
	expect($parser->parse($text))->toBe($expected);
});