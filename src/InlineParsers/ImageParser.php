<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;
use AntonioPrimera\Md\InlineParsers\Traits\InlineParserHelpers;

class ImageParser extends InlineParser
{
	use InlineParserHelpers;
	
	public function parse(string $text): string
	{
		//find all ![label](url){class} tags and extract the label and the url
		$pattern = '/!\[(.*?)\]\s*\((.*?)\)(?:\s*\{(.*?)\})?/s';
		
		return preg_replace_callback($pattern, function($matches) {
			$alt = trim($matches[1]);
			$url = $this->renderUrl(trim($matches[2]));
			$class = $this->renderClasses($matches[3] ?? '');
			
			//return the parsed image tag
			return "<img src=\"$url\" alt=\"$alt\"$class>";
		}, $text);
	}
}