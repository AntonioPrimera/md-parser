<?php
namespace AntonioPrimera\CustomMarkdown\NodeParsers;

class ParagraphParser extends NodeParser
{
	public string|null $alias = 'paragraph';
	
	public function matches(string $part): bool
	{
		return true;
	}
	
	public function parse(string $text): string|null
	{
		return '<p>' . trim($text) . '</p>';
	}
}