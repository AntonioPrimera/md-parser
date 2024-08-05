<?php
namespace AntonioPrimera\Md\MarkdownFlavors;

use AntonioPrimera\Md\Parser;

/**
 * This class is a very basic Markdown flavor factory, used in a Laravel context,
 * creating a Markdown parser with the configuration from the Laravel config file 'md-parser'
 */
class ConfiguredMarkdownParser
{
	
	public static function create(): Parser
	{
		//get the flavor recipe from the config file
		$flavorConfig = config('md-parser.flavor');
		
		return new Parser(
			inlineParsers: $flavorConfig['inlineParsers'],
			blockParsers: $flavorConfig['blockParsers'],
			config: $flavorConfig['config'],
			splitter: $flavorConfig['splitter']
		);
	}
}