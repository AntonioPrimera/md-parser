<?php
namespace AntonioPrimera\Md\Traits;

trait UsesConfig
{
	protected array $config = [];
	
	public function getConfig(string $key, mixed $default = null): mixed
	{
		return $this->config[$key] ?? $default;
	}
	
	public function setConfig(string $key, mixed $value): void
	{
		$this->config[$key] = $value;
	}
}