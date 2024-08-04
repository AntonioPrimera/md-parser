<?php
namespace AntonioPrimera\Md\BlockParsers;

use AntonioPrimera\Md\BlockParser;
use AntonioPrimera\Md\Blocks\MarkdownBlock;

/**
 * Parses headings, in the form of:
 * # Heading level 1
 * ## Heading level 2
 * ...
 *
 * Config: baseHeadingLevel 
 */
class HeadingParser extends BlockParser
{
	
	public function matches(string $text, array $parsedBlocks = []): bool
	{
		return str_starts_with(trim($text), '#');
	}
	
	public function parse(string|MarkdownBlock $text, array &$parsedBlocks = []): string|null
	{
		$trimmedText = trim($text);
		$title = ltrim($trimmedText, '#');
		$baseHeadingLevel = $this->getConfig('baseHeadingLevel', 2);
		$headingLevel = min($baseHeadingLevel - 1 + strlen($trimmedText) - strlen($title), 6);
		$trimmedTitle = trim($title);
		
		return "<h$headingLevel>$trimmedTitle</h$headingLevel>";
	}
}