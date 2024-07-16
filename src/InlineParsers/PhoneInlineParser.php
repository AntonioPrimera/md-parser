<?php
namespace AntonioPrimera\Md\InlineParsers;

class PhoneInlineParser extends AbstractInlineParser
{
	
	public function parse(string $text): string|null
	{
		//find all [cta]...[/cta] tags and extract the attributes from the start tag and the contents between the tags
		$pattern = '/\[tel:(.*?)\](.*?)\[\/tel\]/s';
		return preg_replace_callback($pattern, function($matches){
			$phoneNumber = $this->parsePhoneNumber($matches[1]);
			$contents = $matches[2];
			
			//return the parsed phone number link
			return "<a href='tel:$phoneNumber' class='tel'>$contents</a>";
		}, $text);
	}
	
	protected function parsePhoneNumber(string $phoneNumber, string $countryCode = '0040'): string
	{
		$cleanPhoneNumber = str_replace([' ', '.', '(', ')'], '', $phoneNumber);
		return $countryCode ? $countryCode . substr($cleanPhoneNumber, 1) : $cleanPhoneNumber;
	}
	
}