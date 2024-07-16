<?php
namespace AntonioPrimera\Md\Splitters;

abstract class AbstractMarkdownSplitter
{
	public abstract function split(string|null $text): array;
}