<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\BlockParsers\BlockQuoteParser;
use AntonioPrimera\Md\BlockParsers\UnorderedListItemParser;
use AntonioPrimera\Md\InlineParsers\BoldParser;
use AntonioPrimera\Md\InlineParsers\CtaParser;
use AntonioPrimera\Md\InlineParsers\EmailParser;
use AntonioPrimera\Md\InlineParsers\ItalicParser;
use AntonioPrimera\Md\InlineParsers\LinkParser;
use AntonioPrimera\Md\InlineParsers\LineBreakParser;
use AntonioPrimera\Md\InlineParsers\PhoneParser;
use AntonioPrimera\Md\BlockParsers\HeadingParser;
use AntonioPrimera\Md\BlockParsers\ParagraphNodeParser;
use AntonioPrimera\Md\Parser;

class BasicMarkdownParser
{
	
	public static function create(array $config = []): Parser
	{
		return new Parser(
			inlineParsers: [
				new CtaParser(),
				new PhoneParser(),
				new EmailParser(),
				new LinkParser(),
				new BoldParser(),
				new ItalicParser(),
				new LineBreakParser(),
				//new ImageParser(),
			],
			blockParsers: [
				new HeadingParser(['baseHeadingLevel' => $config['baseHeadingLevel'] ?? 2]),
				new UnorderedListItemParser(),
				new BlockQuoteParser(),
				new ParagraphNodeParser(),
				//new CodeBlockParser(),
			],
			config: $config
		);
	}
}