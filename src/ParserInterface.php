<?php
namespace AntonioPrimera\Md;

interface ParserInterface
{
	public function parse(string $text): string|null;
}