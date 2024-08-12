<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\BlockParsers\BlockQuoteParser;
use AntonioPrimera\Md\BlockParsers\UnorderedListItemParser;
use AntonioPrimera\Md\InlineParsers\BoldItalicParser;
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
				
				//these next 3, have to go in this order, because all of them use "*" as a delimiter
				new BoldItalicParser(),	//this is necessary, because bold and italic both use "*" as a delimiter (this has to go before the BoldParser and ItalicParser)
				new BoldParser(),		//this has to come before the ItalicParser, because it uses a similar syntax
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