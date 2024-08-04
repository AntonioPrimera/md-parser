<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\Blocks\MarkdownBlock;
use AntonioPrimera\Md\Splitters\MarkdownSplitter;
use AntonioPrimera\Md\Splitters\BasicSplitter;
use AntonioPrimera\Md\Traits\UsesConfig;

class Parser
{
	use UsesConfig;
	
	public MarkdownSplitter $splitter;
	
	//the list of parsers, indexed by their alias
	protected array $inlineParsers = [];
	protected array $blockParsers = [];
	protected string $glue = "\n";
	
	//--- Construction ------------------------------------------------------------------------------------------------
	
	public function __construct(
		array                   $inlineParsers = [],
		array                   $blockParsers = [],
		array                   $config = [],
		MarkdownSplitter|string $splitter = "\n",
		string                  $glue = "\n"
	)
	{
		$this->addInlineParsers($inlineParsers);
		$this->addBlockParsers($blockParsers);
		$this->config = $config;
		$this->splitter = is_string($splitter) ? new BasicSplitter($splitter) : $splitter;
		$this->glue = $glue;
	}
	
	//--- Parser handling ---------------------------------------------------------------------------------------------
	
	public function addInlineParsers(array $inlineParsers): static
	{
		foreach ($inlineParsers as $alias => $inlineParser)
			$this->addInlineParser($alias, $inlineParser);
		
		return $this;
	}
	
	public function addInlineParser(string|int $alias, InlineParser|string $inlineParser): static
	{
		$parserAlias = is_string($alias) ? $alias : $inlineParser->alias();
		$this->inlineParsers[$parserAlias] = $inlineParser instanceof InlineParser
			? $inlineParser
			: new $inlineParser($this->getConfig($parserAlias, []));
		
		return $this;
	}
	
	public function addBlockParsers(array $blockParsers): static
	{
		foreach ($blockParsers as $alias => $blockParser)
			$this->addBlockParser($alias, $blockParser);
		
		return $this;
	}
	
	public function addBlockParser(string|int $alias, BlockParser|string $blockParser): static
	{
		$parserAlias = is_string($alias) ? $alias : $blockParser->alias();
		$this->blockParsers[$parserAlias] = $blockParser instanceof BlockParser
			? $blockParser
			: new $blockParser($this->getConfig($parserAlias, []));
		
		return $this;
	}
	
	/**
	 * Set the configuration for a specific parser
	 */
	public function setParserConfig(string $parserAlias, array $config): static
	{
		$parser = $this->blockParsers[$parserAlias] ?? $this->inlineParsers[$parserAlias] ?? null;
		if (!$parser)
			throw new \Exception("Parser with alias '$parserAlias' not found");
		
		foreach ($config as $key => $value)
			$parser->setConfig($key, $value);
		
		return $this;
	}
	
	//--- Parsing -----------------------------------------------------------------------------------------------------
	
	public function parse(string $text): string
	{
		//first parse the text using the inline parsers (this is done before splitting the text into nodes)
		$inlineParsedText = $this->parseUsingInlineParsers($text);
		
		//split the text into nodes
		$blocks = $this->splitter->split($inlineParsedText);
		$parsedBlocks = [];
		$ignoreEmptyBlocks = $this->getConfig('ignoreEmptyBlocks', false);
		
		//parse each node
		foreach ($blocks as $block) {
			//parse the block and add it to the list of parsed blocks if it's not null
			$parsedBlock = $this->parseBlock($block, $parsedBlocks);
			if ($parsedBlock === null || ($ignoreEmptyBlocks && empty($parsedBlock)))
				continue;
			
			$parsedBlocks[] = $parsedBlock;
		}
		
		$this->handleEmptyLines($parsedBlocks);
		
		return implode($this->glue, $parsedBlocks);
	}
	
	//--- Protected helpers -------------------------------------------------------------------------------------------
	
	protected function parseUsingInlineParsers(string $text): string
	{
		$parsedText = $text;
		foreach ($this->inlineParsers as $parser)
			$parsedText = $parser->parse($parsedText);
		
		return $parsedText;
	}
	
	/**
	 * Parse a single block
	 * Each block is parsed by the first block parser that matches it
	 */
	protected function parseBlock(string $node, array &$parsedBlocks): string|MarkdownBlock|null
	{
		//parse the node with the node parsers - the first one that matches will parse the node
		foreach ($this->blockParsers as $parser)
			if ($parser->matches($node))
				return $parser->parse($node, $parsedBlocks);
		
		return $node;
	}
	
	protected function handleEmptyLines(&$parsedBlocks): void
	{
		//determine what the rendered empty lines should look like
		$emptyLine = $this->getConfig('emptyLine', '<p></p>');
		
		//if they are different from an empty string, replace empty blocks with the empty line
		if ($emptyLine !== '')
			$parsedBlocks = arrayMap($parsedBlocks, fn($block) => $block === '' ? $emptyLine : $block);
	}
}