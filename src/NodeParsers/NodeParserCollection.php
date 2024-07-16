<?php
namespace AntonioPrimera\Md\NodeParsers;

use AntonioPrimera\Md\ParserInterface;

class NodeParserCollection implements ParserInterface
{
	protected array $parsers = [];
	
	public function __construct(array $parsers)
	{
		$this->parsers = arrayMapWithKeys($parsers, fn(AbstractNodeParser $parser, $key) => [(is_numeric($key) ? $parser->alias() : $key) => $parser]);
	}
	
	/**
	 * Run the text through all the parsers, until one of them matches and can parse it.
	 * If no parser matches, return the original text
	 */
	public function parse(string $text): string|null
	{
		/* @var AbstractNodeParser $parser */
		foreach ($this->parsers as $parser)
			if ($parser->matches($text))
				return $parser->parse($text);
		
		return $text;
	}
	
	public function getParser(string $parserAlias): AbstractNodeParser|null
	{
		return $this->parsers[$parserAlias] ?? null;
	}
}