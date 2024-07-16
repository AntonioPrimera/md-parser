<?php
namespace AntonioPrimera\Md\InlineParsers;

class EmailInlineParser extends AbstractInlineParser
{
	
	public function parse(string $text): string|null
	{
		//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
		$pattern = '/\[email:(.*?)\](.*?)\[\/email\]/s';
		return preg_replace_callback($pattern, function($matches){
			$emailAddress = $matches[1];
			$contents = $matches[2];
			
			//return the parsed phone number link
			return "<a href='mailto:$emailAddress' class='tel'>$contents</a>";
		}, $text);
	}
}