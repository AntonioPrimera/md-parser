<?php
namespace AntonioPrimera\CustomMarkdown\Splitters;

abstract class MarkdownSplitter
{
	public abstract function split(string|null $text): array;
}