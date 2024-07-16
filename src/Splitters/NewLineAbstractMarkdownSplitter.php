<?php
namespace AntonioPrimera\Md\Splitters;

class NewLineAbstractMarkdownSplitter extends AbstractMarkdownSplitter
{
	public function split(string|null $text): array
	{
		return $text ? explode("\n", $text) : [];
	}
}