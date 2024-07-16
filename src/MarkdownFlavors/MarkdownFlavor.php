<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\InlineParsers\InlineParserCollection;
use AntonioPrimera\Md\NodeParsers\NodeParserCollection;
use AntonioPrimera\Md\ParserInterface;
use AntonioPrimera\Md\Splitters\AbstractMarkdownSplitter;

class MarkdownFlavor implements ParserInterface
{
	public AbstractMarkdownSplitter $splitter;
	public NodeParserCollection $nodeParsers;
	public InlineParserCollection $inlineParsers;
	
	//--- Construction ------------------------------------------------------------------------------------------------
	
	public function __construct(
		AbstractMarkdownSplitter          $splitter,
		NodeParserCollection|array|null   $nodeParsers = null,
		InlineParserCollection|array|null $inlineParsers = null,
		array                             $config = []
	)
	{
		$this->splitter = $splitter;
		$this->nodeParsers = $this->createNodeParserCollection($nodeParsers);
		$this->inlineParsers = $this->createInlineParserCollection($inlineParsers);
		
		foreach ($config as $parserAlias => $parserConfig)
			$this->setParserConfig($parserAlias, $parserConfig);
	}
	
	protected function createNodeParserCollection(NodeParserCollection|array|null $nodeParsers): NodeParserCollection
	{
		return $nodeParsers instanceof NodeParserCollection
			? $nodeParsers
			: new NodeParserCollection($nodeParsers ?? []);
	}
	
	protected function createInlineParserCollection(InlineParserCollection|array|null $inlineParsers): InlineParserCollection
	{
		return $inlineParsers instanceof InlineParserCollection
			? $inlineParsers
			: new InlineParserCollection($inlineParsers ?? []);
	}
	
	//--- Parsing -----------------------------------------------------------------------------------------------------
	
	public function parse(string $text): string
	{
		$nodes = arrayMap($this->splitter->split($text), fn($node) => $this->parseNode($node));
		return implode("\n", $nodes);
	}
	
	protected function parseNode(string $node): string|null
	{
		//parse the node with the node parsers
		$parsedNode = $this->nodeParsers->parse($node);
		
		//parse the node with the inline parsers
		return $this->inlineParsers->parse($parsedNode);
	}
	
	//--- Parser Config -----------------------------------------------------------------------------------------------
	
	public function setConfig(string $parserAlias, string $key, mixed $value): void
	{
		$parserInstance = $this->nodeParsers->getParser($parserAlias) ?? $this->inlineParsers->getParser($parserAlias);
		$parserInstance?->setConfig($key, $value);
	}
	
	public function setParserConfig(string $parserAlias, array $config): void
	{
		foreach ($config as $key => $value)
			$this->setConfig($parserAlias, $key, $value);
	}
}