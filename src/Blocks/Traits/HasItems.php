<?php
namespace AntonioPrimera\Md\Blocks\Traits;

use AntonioPrimera\Md\Blocks\MarkdownBlock;

trait HasItems
{
	public array $items = [];
	
	public function addItem(string|MarkdownBlock $item): void
	{
		$this->items[] = $item;
	}
}