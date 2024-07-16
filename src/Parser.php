<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\MarkdownFlavors\MarkdownFlavor;

class Parser implements ParserInterface
{
    public function __construct(public readonly MarkdownFlavor $flavor)
    {
    }
	
	public static function create(MarkdownFlavor $flavor): static
	{
		return new static($flavor);
	}
	
    //--- Processing methods ------------------------------------------------------------------------------------------
	
	public function parse(string $text): string|null
	{
		return $this->flavor->parse($text);
	}
	
	public function setConfig(string $parserClass, string $key, mixed $value): static
	{
		$this->flavor->setConfig($parserClass, $key, $value);
		return $this;
	}
}
