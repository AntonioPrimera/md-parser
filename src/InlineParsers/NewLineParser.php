<?php
namespace AntonioPrimera\CustomMarkdown\InlineParsers;

class NewLineParser extends InlineParser
{
	const MARKDOWN = 'markdown';
	
	//replace all '|' characters with a new line
	public function parse(string $text): string|null
	{
		$newLineMd = $this->getConfig(self::MARKDOWN, "|");
		return str_replace($newLineMd, "<br>", $text);
	}
}