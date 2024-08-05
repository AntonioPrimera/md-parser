<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\BlockParsers\BlockQuoteParser;
use AntonioPrimera\Md\BlockParsers\UnorderedListItemParser;
use AntonioPrimera\Md\InlineParsers\BoldParser;
use AntonioPrimera\Md\InlineParsers\ImageParser;
use AntonioPrimera\Md\InlineParsers\ItalicParser;
use AntonioPrimera\Md\InlineParsers\LinkParser;
use AntonioPrimera\Md\InlineParsers\LineBreakParser;
use AntonioPrimera\Md\BlockParsers\HeadingParser;
use AntonioPrimera\Md\BlockParsers\ParagraphParser;
use AntonioPrimera\Md\Parser;

class BasicMarkdownParser
{
	
	public static function create(array $config = []): Parser
	{
		return new Parser(
			inlineParsers: [
				new ImageParser(),	//this has to go before the LinkParser, because it uses a similar syntax
				new LinkParser(),
				new BoldParser(),
				new ItalicParser(),
				new LineBreakParser(),	//this has to go last, because other parsers may use "|" in their syntax
			],
			blockParsers: [
				new HeadingParser(['baseHeadingLevel' => $config['baseHeadingLevel'] ?? 2]),
				new UnorderedListItemParser(),
				new BlockQuoteParser(),
				new ParagraphParser(),
				//new CodeBlockParser(),
			],
			config: $config
		);
	}
}