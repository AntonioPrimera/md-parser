<?php
namespace AntonioPrimera\Md\NodeParsers;

class ParagraphNodeParser extends AbstractNodeParser
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