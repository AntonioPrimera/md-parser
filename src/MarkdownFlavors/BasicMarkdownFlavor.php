<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\InlineParsers\BoldInlineParser;
use AntonioPrimera\Md\InlineParsers\CtaInlineParser;
use AntonioPrimera\Md\InlineParsers\EmailInlineParser;
use AntonioPrimera\Md\InlineParsers\ItalicInlineParser;
use AntonioPrimera\Md\InlineParsers\LinkInlineParser;
use AntonioPrimera\Md\InlineParsers\NewLineInlineParser;
use AntonioPrimera\Md\InlineParsers\PhoneInlineParser;
use AntonioPrimera\Md\NodeParsers\HeadingNodeParser;
use AntonioPrimera\Md\NodeParsers\ParagraphNodeParser;
use AntonioPrimera\Md\Splitters\NewLineAbstractMarkdownSplitter;

class BasicMarkdownFlavor
{
	
	public static function create(array $config = []): MarkdownFlavor
	{
		return new MarkdownFlavor(
			splitter: new NewLineAbstractMarkdownSplitter(),
			nodeParsers: [
				new HeadingNodeParser(),
				new ParagraphNodeParser(),
				//new CodeBlockParser(),
				//new BlockquoteParser(),
				//new ListParser(),
			],
			inlineParsers: [
				new NewLineInlineParser(),
				new CtaInlineParser(),
				new PhoneInlineParser(),
				new EmailInlineParser(),
				new BoldInlineParser(),
				new ItalicInlineParser(),
				new LinkInlineParser(),
				//new ImageParser(),
			],
			config: $config
		);
	}
}