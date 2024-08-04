<?php
namespace AntonioPrimera\Md\Splitters;

/**
 * Splits a string into an array of strings, using a delimiter
 */
class BasicSplitter extends MarkdownSplitter
{
	public function __construct(protected string $delimiter = "\n")
	{
	}
	
	public function split(string|null $text): array
	{
		return $text ? explode($this->delimiter, $text) : [];
	}
}