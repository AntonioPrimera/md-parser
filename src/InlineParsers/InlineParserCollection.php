<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\ParserInterface;

class InlineParserCollection implements ParserInterface
{
	protected array $parsers = [];
	
	/**
	 * Receives an array of InlineParser instances and stores them in a property
	 */
	public function __construct(array $parsers)
	{
		$this->parsers = arrayMapWithKeys($parsers, fn(AbstractInlineParser $parser, $key) => [(is_numeric($key) ? $parser->alias() : $key) => $parser]);
	}
	
	/**
	 * Run the text through all the parsers in a chain, passing the result of each parser to the next one
	 */
	public function parse(string $text): string|null
	{
		$parsedText = $text;
		
		/* @var AbstractInlineParser $parser */
		foreach ($this->parsers as $parser)
			$parsedText = $parser->parse($parsedText);
		
		return $parsedText;
	}
	
	public function getParser(string $parserAlias): AbstractInlineParser|null
	{
		return $this->parsers[$parserAlias] ?? null;
	}
}