<?php

function getListItemLevel(string $text): int
{
	//keep the leading empty space
	$leadingEmptySpace = substr($text, 0, strspn($text, " \t"));
	
	//replace all double spaces with tabs, so it's easier to count the level
	$leadingEmptySpace = str_replace('  ', "\t", $leadingEmptySpace);
	
	//return the number of tabs
	return substr_count($leadingEmptySpace, "\t");
}