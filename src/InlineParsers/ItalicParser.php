<?php
namespace AntonioPrimera\CustomMarkdown\InlineParsers;

class ItalicParser extends InlineParser
{
	
	public function parse(string $text): string|null
	{
		//find all ***...*** tags and extract the contents between the tags
		$pattern = '/\*(.+)\*/s';
		return preg_replace_callback($pattern, fn($matches) => "<em>$matches[1]</em>", $text);
	}
	
}