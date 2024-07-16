<?php
namespace AntonioPrimera\CustomMarkdown\MarkdownFlavors;

use AntonioPrimera\CustomMarkdown\InlineParsers\BoldItalicParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\BoldParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\CtaParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\EmailParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\ItalicParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\LinkParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\NewLineParser;
use AntonioPrimera\CustomMarkdown\InlineParsers\PhoneParser;
use AntonioPrimera\CustomMarkdown\NodeParsers\HeadingParser;
use AntonioPrimera\CustomMarkdown\NodeParsers\ParagraphParser;
use AntonioPrimera\CustomMarkdown\Splitters\NewLineMarkdownSplitter;

class BasicMarkdownFlavor
{
	
	public static function create(array $config = []): MarkdownFlavor
	{
		return new MarkdownFlavor(
			splitter: new NewLineMarkdownSplitter(),
			nodeParsers: [
				new HeadingParser(),
				new ParagraphParser(),
				//new CodeBlockParser(),
				//new BlockquoteParser(),
				//new ListParser(),
			],
			inlineParsers: [
				new NewLineParser(),
				new CtaParser(),
				new PhoneParser(),
				new EmailParser(),
				new BoldParser(),
				new ItalicParser(),
				new LinkParser(),
				//new ImageParser(),
			],
			config: $config
		);
	}
}