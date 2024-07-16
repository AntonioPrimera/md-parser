<?php
namespace AntonioPrimera\Md\InlineParsers;

class NewLineInlineParser extends AbstractInlineParser
{
	const MARKDOWN = 'markdown';
	
	//replace all '|' characters with a new line
	public function parse(string $text): string|null
	{
		$newLineMd = $this->getConfig(self::MARKDOWN, "|");
		return str_replace($newLineMd, "<br>", $text);
	}
}