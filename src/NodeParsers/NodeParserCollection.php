<?php
namespace AntonioPrimera\CustomMarkdown\NodeParsers;

use AntonioPrimera\CustomMarkdown\ParserInterface;

class NodeParserCollection implements ParserInterface
{
	protected array $parsers = [];
	
	public function __construct(array $parsers)
	{
		$this->parsers = arrayMapWithKeys($parsers, fn(NodeParser $parser) => [$parser->alias() => $parser]);
	}
	
	/**
	 * Run the text through all the parsers, until one of them matches and can parse it.
	 * If no parser matches, return the original text
	 */
	public function parse(string $text): string|null
	{
		/* @var NodeParser $parser */
		foreach ($this->parsers as $parser)
			if ($parser->matches($text))
				return $parser->parse($text);
		
		return $text;
	}
	
	public function getParser(string $parserAlias): NodeParser|null
	{
		return $this->parsers[$parserAlias] ?? null;
	}
}