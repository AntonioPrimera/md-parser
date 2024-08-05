<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\Blocks\MarkdownBlock;
use AntonioPrimera\Md\Traits\UsesConfig;

abstract class BlockParser extends AbstractParser
{
	public abstract function matches(string $text, array $parsedBlocks = []): bool;
	
	public abstract function parse(string $text, array &$parsedBlocks = []): string|MarkdownBlock|null;
}