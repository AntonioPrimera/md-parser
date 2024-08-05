<?php
namespace AntonioPrimera\Md\Traits;

trait UsesConfig
{
	protected array $config = [];
	
	public function getConfig(string $key, mixed $default = null): mixed
	{
		return $this->config[$key] ?? $default;
	}
	
	public function setConfig(string|array $key, mixed $value = null): void
	{
		if (is_array($key)) {
			$this->config = array_merge($this->config, $key);
			return;
		}
		
		$this->config[$key] = $value;
	}
	
	public function set()
	{
	
	}
}