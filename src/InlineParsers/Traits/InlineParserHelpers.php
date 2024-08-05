<?php

namespace AntonioPrimera\Md\InlineParsers\Traits;

trait InlineParserHelpers
{
	protected function renderClasses(string $classes): string
	{
		if (!$classes) return '';
		
		$classList = explode(',', str_replace(' ', ',', $classes));
		$classList = array_map(fn($class) => trim($class), $classList);
		$classList = array_filter($classList);
		
		return ' class="' . implode(' ', $classList) . '"';
	}
	
	protected function isExternalLink(string $url): bool
	{
		return str_starts_with($url, 'http');
	}
	
	protected function renderUrl(string $url): string
	{
		//optionally process the url with a custom processor (e.g. to add a base url or to process named routes)
		$urlProcessor = $this->getConfig('urlProcessor');
		return is_callable($urlProcessor) ? call_user_func($urlProcessor, $url) : $url;
	}
}