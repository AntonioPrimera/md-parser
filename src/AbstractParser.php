<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\Traits\UsesConfig;

abstract class AbstractParser
{
	use UsesConfig;
	
	public function __construct(array $config = [])
	{
		$this->config = $config;
	}
	
	/**
	 * Returns the class name in kebab case without the "-parser" suffix
	 * e.g. "LineBreakParser" -> "line-break"
	 */
	public function alias(): string
	{
		return str_replace('-parser', '', kebabCase(classBasename($this)));
	}
}