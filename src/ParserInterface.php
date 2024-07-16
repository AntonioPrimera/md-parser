<?php
namespace AntonioPrimera\CustomMarkdown;

interface ParserInterface
{
	public function parse(string $text): string|null;
}