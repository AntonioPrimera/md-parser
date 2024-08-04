<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;

class LinkParser extends InlineParser
{
	
	//public function parse(string $text): string
	//{
	//	//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
	//	$pattern = '/\[link:(.*?)\](.*?)\[\/link\]/s';
	//	return preg_replace_callback($pattern, function($matches){
	//		$url = $matches[1];
	//		$target = $this->isInternalLink($url) ? '' : 'target="_blank"';
	//		$contents = $matches[2];
	//
	//		//return the parsed phone number link
	//		return "<a href='$url' class='link' $target>$contents</a>";
	//	}, $text);
	//}
	
	public function parse(string $text): string
	{
		$openExternalLinksInNewTab = $this->getConfig('openExternalLinksInNewTab', true);
		
		//find all [label](url) tags and extract the label and the url
		$pattern = '/\[(.*?)\]\s*\((.*?)\)/s';
		return preg_replace_callback($pattern, function($matches) use ($openExternalLinksInNewTab) {
			$label = trim($matches[1]);
			$url = trim($matches[2]);
			$target = $this->isExternalLink($url) && $openExternalLinksInNewTab ? ' target="_blank"' : '';
			
			//return the parsed phone number link
			return "<a href=\"$url\"$target>$label</a>";
		}, $text);
	}
	
	//public function isInternalLink(string $url): bool
	//{
	//	 return str_starts_with($url, '/')
	//		 || str_starts_with($url, '#')
	//		 || str_contains($url, $_SERVER['HTTP_HOST']);
	//}
	
	protected function isExternalLink(string $url): bool
	{
		return str_starts_with($url, 'http');
	}
}