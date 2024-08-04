<?php
namespace AntonioPrimera\Md\Blocks;

class ListItem extends MarkdownBlock
{
	//the string content of the list item
	public string $content;
	
	//the level of the list item (how many tabs or spaces are before the list item)
	public readonly int $level;
	
	//an array of sub-items contained in the list item (usually other lists)
	public array $items = [];
	
	public function __construct(string $content)
	{
		$this->level = $this->getLevel($content);
		$this->content = $this->cleanUpItem($content);
	}
	
	/**
	 * Add a new sub-item to the list item
	 */
	public function addItem(MarkdownBlock $item): void
	{
		//if it's not a list item, just add it to the list
		if (!($item instanceof ListItem)) {
			$this->items[] = $item;
			return;
		}
		
		//if we have a list item, add it to the last List instance in the list of items
		$lastItem = $this->lastItem();
		
		if ($lastItem instanceof UnorderedList) {
			$lastItem->addItem($item);
			return;
		}
		
		//if there's no list instance, create a new one and add the item to it
		$this->items[] = new UnorderedList($item);
	}
	
	/**
	 * Get the last sub-item of this list item
	 */
	public function lastItem(): MarkdownBlock|null
	{
		return end($this->items) ?: null;
	}
	
	//--- Protected helpers -------------------------------------------------------------------------------------------
	
	/**
	 * Clean up the list item text, removing the leading
	 * list item character and any trailing whitespace
	 */
	protected function cleanUpItem(string $text): string
	{
		$trimmedText = ltrim($text, "-*+ \t");
		return rtrim($trimmedText);
	}
	
	/**
	 * Determine the level of the list item, based on the leading whitespace
	 */
	protected function getLevel(string $text): int
	{
		//keep the leading empty space
		$leadingEmptySpace = substr($text, 0, strspn($text, " \t"));
		
		//replace all double spaces with tabs, so it's easier to count the level
		$leadingEmptySpace = str_replace('    ', "\t", $leadingEmptySpace);
		
		//return the number of tabs
		return substr_count($leadingEmptySpace, "\t");
	}
	
	//--- Interface implementation ------------------------------------------------------------------------------------
	
	public function __toString(): string
	{
		$content = $this->content;
		
		//if the list item contains sub-lists or other Block elements, render them
		$items = implode("", $this->items);
		
		return "<li>{$content}{$items}</li>";
	}
}