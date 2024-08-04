<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;

/**
 * Replaces a specific string with <br> tags, by default the '|' character
 * Config: 'lineBreaker' => string [default: '|']
 */
class LineBreakParser extends InlineParser
{
	//replace all '|' characters with a new line
	public function parse(string $text): string
	{
		$newLineMd = $this->getConfig('lineBreak', "|");
		return str_replace($newLineMd, "<br>", $text);
	}
}