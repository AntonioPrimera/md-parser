<?php
namespace AntonioPrimera\Md\BlockParsers;

use AntonioPrimera\Md\BlockParser;
use AntonioPrimera\Md\Blocks\MarkdownBlock;

class BlockQuoteParser extends BlockParser
{
	
	public function matches(string $text, array $parsedBlocks = []): bool
	{
		return str_starts_with($text, '>');
	}
	
	public function parse(string $text, array &$parsedBlocks = []): string|MarkdownBlock|null
	{
		//remove the '>' character and any whitespace from the beginning of the line
		$text = ltrim($text, "> \t");
		$text = rtrim($text);
		
		return "<blockquote>$text</blockquote>";
	}
}