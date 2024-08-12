<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;

class ItalicParser extends InlineParser
{
	
	public function parse(string $text): string
	{
		//find all *...* tags and extract the contents between the tags
		$pattern = '/\*(.+?)\*/s';
		return preg_replace_callback($pattern, fn($matches) => "<em>$matches[1]</em>", $text);
	}
	
}