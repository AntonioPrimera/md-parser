<?php
namespace AntonioPrimera\Md\Splitters;

abstract class MarkdownSplitter
{
	public abstract function split(string|null $text): array;
}