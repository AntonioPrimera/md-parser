<?php
return [
	'flavor' => [
		//'factory' => \AntonioPrimera\Md\MarkdownFlavors\BasicMarkdownParser::class,
		
		'inlineParsers' => [
			\AntonioPrimera\Md\InlineParsers\ImageParser::class,
			\AntonioPrimera\Md\InlineParsers\LinkParser::class,
			\AntonioPrimera\Md\InlineParsers\BoldParser::class,
			\AntonioPrimera\Md\InlineParsers\ItalicParser::class,
			\AntonioPrimera\Md\InlineParsers\LineBreakParser::class
		],
		
		'blockParsers' => [
			\AntonioPrimera\Md\BlockParsers\HeadingParser::class,
			\AntonioPrimera\Md\BlockParsers\UnorderedListItemParser::class,
			\AntonioPrimera\Md\BlockParsers\BlockQuoteParser::class,
			\AntonioPrimera\Md\BlockParsers\ParagraphParser::class
		],
		
		'splitter' => "\n",
		
		'config' => [
			'heading' => [
				'baseHeadingLevel' => 2
			],
			'line-break' => [
				'lineBreak' => "|"
			]
		]
	]
];