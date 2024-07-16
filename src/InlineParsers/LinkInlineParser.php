<?php
namespace AntonioPrimera\Md\InlineParsers;

class LinkInlineParser extends AbstractInlineParser
{
	
	public function parse(string $text): string|null
	{
		//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
		$pattern = '/\[link:(.*?)\](.*?)\[\/link\]/s';
		return preg_replace_callback($pattern, function($matches){
			$url = $matches[1];
			$target = $this->isInternalLink($url) ? '' : 'target="_blank"';
			$contents = $matches[2];
			
			//return the parsed phone number link
			return "<a href='$url' class='link' $target>$contents</a>";
		}, $text);
	}
	
	public function isInternalLink(string $url): bool
	{
		 return str_starts_with($url, '/')
			 || str_starts_with($url, '#')
			 || str_contains($url, $_SERVER['HTTP_HOST']);
	}
}