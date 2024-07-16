<?php
namespace AntonioPrimera\CustomMarkdown\Splitters;

class NewLineMarkdownSplitter extends MarkdownSplitter
{
	public function split(string|null $text): array
	{
		return $text ? explode("\n", $text) : [];
	}
}