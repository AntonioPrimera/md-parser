<?php
namespace AntonioPrimera\Md\InlineParsers;

use AntonioPrimera\Md\InlineParser;
use AntonioPrimera\Md\InlineParsers\Traits\InlineParserHelpers;

/**
 * Parses simple links, phone numbers and email addresses
 *
 * It uses the following syntax (the classes part is optional):
 * [Label](url){classes}
 *
 * If the url is an email address, it will be rendered as a mailto link
 * If the url is a phone number, it will be rendered as a tel link
 * If the url is an external link, it will be rendered with target="_blank",
 * unless the config option openExternalLinksInNewTab is set to false
 * The classes part will be rendered as a class attribute. You can specify
 * multiple classes separated by spaces or commas (e.g {class1 class2} or {class1, class2})
 */
class LinkParser extends InlineParser
{
	use InlineParserHelpers;
	
	public function parse(string $text): string
	{
		$openExternalLinksInNewTab = $this->getConfig('openExternalLinksInNewTab', true);
		
		//find all [label](url){class} tags and extract the label and the url
		$pattern = '/\[(.*?)\]\s*\((.*?)\)(?:\s*\{(.*?)\})?/s';
		return preg_replace_callback($pattern, function($matches) use ($openExternalLinksInNewTab) {
			$label = trim($matches[1]);
			$url = $this->renderLinkUrl(trim($matches[2]));
			$target = $this->isExternalLink($url) && $openExternalLinksInNewTab ? ' target="_blank"' : '';
			$class = $this->renderClasses($matches[3] ?? '');
			
			//return the parsed phone number link
			return "<a href=\"$url\"$target$class>$label</a>";
		}, $text);
	}
	
	//--- Protected helpers -------------------------------------------------------------------------------------------
	
	protected function renderLinkUrl(string $url): string
	{
		return match (true) {
			$this->isEmail($url) => $this->renderEmailUrl($url),
			$this->isPhoneNumber($url) => $this->renderPhoneNumberUrl($url),
			default => $this->renderUrl($url)
		};
	}
	
	protected function isEmail(string $url): bool
	{
		return filter_var($url, FILTER_VALIDATE_EMAIL);
	}
	
	protected function renderEmailUrl(string $url): string
	{
		return "mailto:$url";
	}
	
	protected function isPhoneNumber(string $url): bool
	{
		//a phone number can optionally start with a plus sign and can contain only digits, parentheses, spaces, dots and hyphen
		return preg_match('/^\+?[0-9\(\)\s\.\-]+$/', $url);
	}
	
	protected function renderPhoneNumberUrl(string $url): string
	{
		//replace initial + with 00 and remove all non-digit characters
		if (str_starts_with($url, '+'))
			$url = '00' . substr($url, 1);
		
		$phoneNumber = preg_replace('/\D/', '', $url);
		
		//return the tel link
		return "tel:$phoneNumber";
	}
}