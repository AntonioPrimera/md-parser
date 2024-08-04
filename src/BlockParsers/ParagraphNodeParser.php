<?php
namespace AntonioPrimera\Md\BlockParsers;

use AntonioPrimera\Md\BlockParser;

class ParagraphNodeParser extends BlockParser
{
	public string|null $alias = 'paragraph';
	
	public function matches(string $text, array $parsedBlocks = []): bool
	{
		return true;
	}
	
	public function parse(string $text, array &$parsedBlocks = []): string
	{
		//return a paragraph block if the text is not empty, otherwise return an empty block
		$trimmedText = trim($text);
		return $trimmedText ? "<p>$trimmedText</p>" : '';
	}
}