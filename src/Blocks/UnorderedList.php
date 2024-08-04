<?php
namespace AntonioPrimera\Md\Blocks;

use AntonioPrimera\Md\Blocks\Traits\HasItems;

class UnorderedList extends MarkdownBlock
{
	public array $items = [];
	public readonly int $level;
	
	public function __construct(array|ListItem $items)
	{
		$this->items = is_array($items) ? $items : [$items];
		//set the level of the list to the level of the first item
		$this->level = reset($this->items)->level;
	}
	
	public function __toString(): string
	{
		//$items = array_map(fn($item) => "<li>$item</li>", $this->items);
		$items = implode("", $this->items);
		
		return "<ul>$items</ul>";
	}
	
	/**
	 * Add a new item to the list
	 * Only ListItem instances can be added to an UnorderedList
	 */
	public function addItem(ListItem $item): void
	{
		//if the item has the same level as the list, add it to the list
		if ($item->level === $this->level) {
			$this->items[] = $item;
			return;
		}
		
		//if the item has a higher level, add it to the last item in the list
		if ($item->level > $this->level)
			$this->lastListItem()->addItem($item);
		
		//if the item has a lower level, don't do anything (should be handled outside of this method)
	}
	
	public function lastListItem(): ListItem
	{
		$lastItem = end($this->items);
		
		if (!$lastItem) {
			$lastItem = new ListItem('');
			$this->items[] = $lastItem;
		}
		
		return $lastItem;
	}
}