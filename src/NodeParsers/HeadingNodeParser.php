<?php
namespace AntonioPrimera\Md\NodeParsers;

class HeadingNodeParser extends AbstractNodeParser
{
	const BASE_HEADING_LEVEL = 'base_heading_level';
	
	public string|null $alias = 'heading';
	
	public function matches(string $part): bool
	{
		return str_starts_with(trim($part), '#');
	}
	
	public function parse(string $text): string|null
	{
		$trimmedText = trim($text);
		$title = ltrim($trimmedText, '#');
		$baseHeadingLevel = $this->getConfig(self::BASE_HEADING_LEVEL, 2);
		$headingLevel = min($baseHeadingLevel - 1 + strlen($trimmedText) - strlen($title), 6);
		$trimmedTitle = trim($title);
		
		return "<h$headingLevel>$trimmedTitle</h$headingLevel>";
	}
}