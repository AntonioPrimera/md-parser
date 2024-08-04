<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\Blocks\MarkdownBlock;
use AntonioPrimera\Md\Traits\UsesConfig;

abstract class BlockParser extends AbstractParser
{
	//optional inline parsers that can be used by this block parser
	protected array $inlineParsers = [];
	
	public abstract function matches(string $text, array $parsedBlocks = []): bool;
	
	public abstract function parse(string $text, array &$parsedBlocks = []): string|MarkdownBlock|null;
	
	public function addParser(InlineParser $parser): void
	{
		$this->inlineParsers[$parser->alias()] = $parser;
	}
	
	public function getParser(string $alias): InlineParser|null
	{
		return $this->inlineParsers[$alias] ?? null;
	}
}