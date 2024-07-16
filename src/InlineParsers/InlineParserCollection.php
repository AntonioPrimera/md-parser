<?php
namespace AntonioPrimera\CustomMarkdown\InlineParsers;

use AntonioPrimera\CustomMarkdown\ParserInterface;

class InlineParserCollection implements ParserInterface
{
	protected array $parsers = [];
	
	/**
	 * Receives an array of InlineParser instances and stores them in a property
	 */
	public function __construct(array $parsers)
	{
		$this->parsers = arrayMapWithKeys($parsers, fn(InlineParser $parser) => [$parser->alias() => $parser]);
	}
	
	/**
	 * Run the text through all the parsers in a chain, passing the result of each parser to the next one
	 */
	public function parse(string $text): string|null
	{
		$parsedText = $text;
		
		/* @var InlineParser $parser */
		foreach ($this->parsers as $parser)
			$parsedText = $parser->parse($parsedText);
		
		return $parsedText;
	}
	
	public function getParser(string $parserAlias): InlineParser|null
	{
		return $this->parsers[$parserAlias] ?? null;
	}
}