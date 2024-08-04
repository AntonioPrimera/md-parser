<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\Traits\UsesConfig;

abstract class InlineParser extends AbstractParser
{
	public abstract function parse(string $text): string;
}