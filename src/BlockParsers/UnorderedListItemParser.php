<?php
namespace AntonioPrimera\Md\BlockParsers;

use AntonioPrimera\Md\BlockParser;
use AntonioPrimera\Md\Blocks\ListItem;
use AntonioPrimera\Md\Blocks\MarkdownBlock;
use AntonioPrimera\Md\Blocks\UnorderedList;

class UnorderedListItemParser extends BlockParser
{
	
	public function matches(string $text, array $parsedBlocks = []): bool
	{
		return in_array(ltrim($text)[0] ?? '', ['-', '*', '+']);
	}
	
	public function parse(string $text, array &$parsedBlocks = []): string|MarkdownBlock|null
	{
		//create the item
		$item = new ListItem($text);
		
		//check the last parsed node to see if it's an unordered list
		$lastParsedNode = $this->lastNonEmptyParsedBlock($parsedBlocks);
		
		//if it's a list with a lower or equal level, add the current line as a new item to the list
		if ($lastParsedNode instanceof UnorderedList && $item->level >= $lastParsedNode->level) {
			$lastParsedNode->addItem($item);
			
			//we need to remove empty nodes, to they don't add up
			//e.g. when the user leaves an empty line between list items
			$this->removeLastEmptyParsedBlocks($parsedBlocks);
			return null;
		}
		
		//if it's not, create a new unordered list and add the current line as a new item to the list
		return new UnorderedList($item);
	}
	
	//--- Protected helpers -------------------------------------------------------------------------------------------
	
	protected function lastNonEmptyParsedBlock(array $parsedNodes): MarkdownBlock|string|null
	{
		//set the pointer to the last node, and go back until a non-empty string node is found
		$lastNode = end($parsedNodes);
		
		while ($lastNode === '')
			$lastNode = prev($parsedNodes);
		
		//return the last non-empty node, or null if the beginning of the array was reached ($lastNode === false)
		return $lastNode ?: null;
	}
	
	protected function removeLastEmptyParsedBlocks(array &$parsedNodes): void
	{
		while (end($parsedNodes) === '')
			array_pop($parsedNodes);
	}
}