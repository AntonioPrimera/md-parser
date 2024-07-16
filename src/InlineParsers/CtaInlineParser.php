<?php
namespace AntonioPrimera\Md\InlineParsers;

class CtaInlineParser extends AbstractInlineParser
{
	
	public function parse(string $text): string|null
	{
		//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
		$pattern = '/\[cta(.*?)\](.*?)\[\/cta\]/s';
		$text = preg_replace_callback($pattern, function($matches){
			$attributes = $matches[1];
			$contents = $matches[2];
			
			//return the parsed cta
			return "<a $attributes class='cta'>$contents</a>";
		}, $text);
		
		return $text;
	}
	
}