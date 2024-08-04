<?php

use AntonioPrimera\Md\MarkdownFlavors\BasicMarkdownParser;

test('it can process a simple unordered list', function () {
	$string =
<<<EOT
- Item 1
 - Item 2
-  Item 3
 -	 Item 4
 -		 Item 5
EOT;
	$processor = BasicMarkdownParser::create();
	
	expect($processor->parse($string))
		->toBe("<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li><li>Item 4</li><li>Item 5</li></ul>");
});

test('it can process a nested unordered list with mixed spaces and tabs for indenting', function () {
	$string =
<<<EOT
- Item 1
- Item 2
    - Item 2.1
	- Item 2.2
		- Item 2.2.1
        - Item 2.2.2
   - Item 3
  - Item 4
	- Item 4.1
EOT;
	$processor = BasicMarkdownParser::create();
	
	expect($processor->parse($string))
		->toBe("<ul><li>Item 1</li><li>Item 2<ul><li>Item 2.1</li><li>Item 2.2<ul><li>Item 2.2.1</li><li>Item 2.2.2</li></ul></li></ul></li><li>Item 3</li><li>Item 4<ul><li>Item 4.1</li></ul></li></ul>");
});

test('it creates a new list if a list item of lower level is encountered', function () {
	$string =
<<<EOT
		- Item 1
			- Item 1.1
	- Item 2
- Item 3
EOT;
	
	$processor = BasicMarkdownParser::create();
	
	expect($processor->parse($string))
		->toBe("<ul><li>Item 1<ul><li>Item 1.1</li></ul></li></ul>\n<ul><li>Item 2</li></ul>\n<ul><li>Item 3</li></ul>");
});

test('it removes empty lines between list items', function () {
	$string =
<<<EOT
- Item 1

- Item 2

	- Item 2.1

	- Item 2.2

	
	
- Item 3
EOT;
	
	$processor = BasicMarkdownParser::create();
	
	expect($processor->parse($string))
		->toBe("<ul><li>Item 1</li><li>Item 2<ul><li>Item 2.1</li><li>Item 2.2</li></ul></li><li>Item 3</li></ul>");
});

