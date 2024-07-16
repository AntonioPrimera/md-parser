<?php
namespace AntonioPrimera\Md;

use AntonioPrimera\Md\NodeParsers\AbstractNodeParser;

class OLD_MarkdownPart
{
	protected string $trimmedPart;
	
	public function __construct(protected string $part, protected array $processors)
	{
		$this->trimmedPart = trim($part, " \t\n\r\0\x0B");
	}
	
    public static function from(string $part, array $processors): static
    {
        return new static($part, $processors);
    }
	
    //--- Type checks -------------------------------------------------------------------------------------------------
	
	public function parse(): string|null
	{
		//find the processor that matches the part and process it
		foreach ($this->processors as $processor)
			if ($processor instanceof AbstractNodeParser && $processor->matches($this->part))
				return $processor->process($processor->usesTrimmedPart() ? $this->trimmedPart : $this->part);
		
		//if no processor was found, return the part as is
		return $this->part;
	}
	
    //public function isSubTitle()
    //{
    //    return str_starts_with($this->content, '##')
    //        || (str_starts_with($this->content, '[subtitle:') && str_ends_with($this->content, ']'));
    //}
	//
    //public function isTitle()
    //{
    //    return str_starts_with($this->content, '#')
    //        || (str_starts_with($this->content, '[title:') && str_ends_with($this->content, ']'));
    //}
	//
    //public function isImage()
    //{
    //    return str_starts_with($this->content, '[img:')
    //        && str_ends_with($this->content, ']');
    //}
	//
    //public function isQuote()
    //{
    //    return str_starts_with($this->content, '|')
    //        || (str_starts_with($this->content, '[quote:') && str_ends_with($this->content, ']'));
    //}
	//
    ////--- Parsers -----------------------------------------------------------------------------------------------------
	//
    //protected function parseParagraph(string $content)
    //{
    //    $parsedContent = $this->replaceLinks($content);
    //    $parsedContent = $this->replaceBold($parsedContent);
    //    return $this->replaceItalic($parsedContent);
    //}
	//
    //protected function parseSubTitle(string $content)
    //{
    //    if (str_starts_with($content, '##'))
    //        return $this->unwrap($content, '##');
	//
    //    if (str_starts_with($content, '[subtitle:') && str_ends_with($content, ']'))
    //        return $this->unwrap($content, '[subtitle:', ']');
	//
    //    return $content;
    //}
	//
    //protected function parseTitle(string $content)
    //{
    //    if (str_starts_with($content, '#'))
    //        return $this->unwrap($content, '#');
	//
    //    if (str_starts_with($content, '[title:') && str_ends_with($content, ']'))
    //        return $this->unwrap($content, '[title:', ']');
	//
    //    return $content;
    //}
	//
    //protected function parseImage(string $content)
    //{
    //    if (str_starts_with($content, '[img:') && str_ends_with($content, ']'))
    //        return $this->unwrap($content, '[img:', ']');
	//
    //    return $content;
    //}
	//
    //protected function parseQuote(string $content)
    //{
    //    if (str_starts_with($content, '|'))
    //        return $this->unwrap($content, '|');
	//
    //    if (str_starts_with($content, '[quote:') && str_ends_with($content, ']'))
    //        return $this->unwrap($content, '[quote:', ']');
	//
    //    return $content;
    //}
	//
    //protected function replaceLinks(string $content): string
    //{
    //    return preg_replace_callback('/\[link:(.*?)\|(.*?)\]/', function ($matches) {
    //        $url = $matches[1];
    //        $label = $matches[2];
	//
    //        return "<a href='$url' target='_blank'>$label</a>";
    //    }, $content);
    //}
	//
    //protected function replaceBold(string $content): string
    //{
    //    return preg_replace_callback('/\*(.*?)\*/', function ($matches) {
    //        $label = $matches[1];
	//
    //        return "<strong>$label</strong>";
    //    }, $content);
    //}
	//
    //protected function replaceItalic(string $content): string
    //{
    //    return preg_replace_callback('/_(.*?)_/', function ($matches) {
    //        $label = $matches[1];
	//
    //        return "<em>$label</em>";
    //    }, $content);
    //}
	//
    ////--- Wrappers ----------------------------------------------------------------------------------------------------
	//
    //protected function wrapParagraph(string $content)
    //{
    //    return "<p>$content</p>";
    //}
	//
    //protected function wrapSubTitle(string $content)
    //{
    //    return "<h3>$content</h3>";
    //}
	//
    //protected function wrapTitle(string $content)
    //{
    //    return "<h2>$content</h2>";
    //}
	//
    //protected function wrapImage(string $mediaUid)
    //{
    //    $image = $this->findImageByUid($mediaUid);
	//
    //    if (!$image)
    //        return "<img src='/img/default-post-image.webp' alt='$this->post->title'>";
	//
    //    return $image->img('responsive', ['alt' => $image->getCustomProperty('alt')])
    //        ->toHtml();
    //}
	//
    //protected function wrapQuote(string $content)
    //{
    //    return "<blockquote>$content</blockquote>";
    //}
	//
    ////--- Protected helpers -------------------------------------------------------------------------------------------
	//
    //protected function unwrap(string $content, string $prefix, string $suffix = ''): string
    //{
    //    return trim(substr($content, strlen($prefix), $suffix ? -strlen($suffix) : null), " \t\n\r\0\x0B");
    //}
	//
    //protected function findImageByUid(string $uid): Media|null
    //{
    //    return $this->post
    //        ->getMedia('post-media')
    //        ->first(fn(Media $media) => strtolower($media->getCustomProperty('uid')) === strtolower($uid));
    //}
	//
    ////--- Interface implementation ------------------------------------------------------------------------------------
	//
    //public function toHtml()
    //{
    //    //if ($this->isParagraph())
    //    //    return $this->wrapParagraph($this->parseParagraph($this->content));
	//
    //    //this has to go before the title check, because the title check also matches the subtitle
    //    if ($this->isSubTitle())
    //        return $this->wrapSubTitle($this->parseSubTitle($this->content));
	//
    //    if ($this->isTitle())
    //        return $this->wrapTitle($this->parseTitle($this->content));
	//
    //    if ($this->isImage())
    //        return $this->wrapImage($this->parseImage($this->content));
	//
    //    if ($this->isQuote())
    //        return $this->wrapQuote($this->parseQuote($this->content));
	//
    //    return $this->wrapParagraph($this->parseParagraph($this->content)); //$this->content;
    //}
}
