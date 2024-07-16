<?php
namespace AntonioPrimera\CustomMarkdown;

abstract class Parser implements ParserInterface
{
	
	/**
	 * The parser alias, so it can be easily addressed in the config
	 * If not set, the fully qualified class name will be used as alias
	 */
	public string|null $alias = null;
	
	public function __construct(protected array $config = [])
	{
	}
	
	//--- Config handling ---------------------------------------------------------------------------------------------
	
	public function getConfig(string $key, mixed $default = null): mixed
	{
		return $this->config[$key] ?? $default;
	}
	
	public function setConfig(string $key, mixed $value): void
	{
		$this->config[$key] = $value;
	}
	
	public function alias(): string
	{
		return $this->alias ?? static::class;
	}
}