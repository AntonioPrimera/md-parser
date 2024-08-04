<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;

class CtaParser extends InlineParser
{
	
	
	//public function parse(string $text): string
	//{
	//	//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
	//	$pattern = '/\[cta(.*?)\](.*?)\[\/cta\]/s';
	//	$text = preg_replace_callback($pattern, function($matches){
	//		$attributes = $matches[1];
	//		$contents = $matches[2];
	//
	//		//return the parsed cta
	//		return "<a $attributes class='cta'>$contents</a>";
	//	}, $text);
	//
	//	return $text;
	//}
	
	public function parse(string $text): string
	{
		//find all [cta:label](url) tags and extract the label and the url
		$pattern = '/\[cta:(.*?)\]\s*\((.*?)\)/s';
		return preg_replace_callback($pattern, function($matches){
			$label = trim($matches[1]);
			$url = trim($matches[2]);
			
			//return the parsed cta
			return "<a href='$url' class='cta'>$label</a>";
		}, $text);
	}
}