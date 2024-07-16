# Custom Markdown Parser

This is a highly customizable Markdown parser, that allows you to create any Markdown flavor, whether it's a standard one
or something you've just invented.

For example, you could create a Markdown flavor that allows you to embed images with an ID (of an object stored in the DB) or a slug,
or a custom tag that allows you to embed a hero-icon by its name. You can even decide that paragraphs should be separated
by a `|` character instead of a newline.

```markdown
An image:
[image:/img/welcome.png] This is the alt text for an image with a relative url [/image]
[image:124] This is the alt text for an image with an id, as stored in the DB [/image]

A list of items with hero-icons:
## Contact
[heroicon:phone] [tel:1234567890] (1234) 567 890 [/tel]
[heroicon:envelope] [mailto:abc@cde.test] Mail me [/mailto]

A gallery:
[gallery:/img/gallery/1.jpg|/img/gallery/2.jpg|/img/gallery/3.jpg] This is the gallery title [/gallery]

Or even a special internal link to an article with a slug:
[article:my-article-slug] Read more about this [/article]
```

## Usage

The main parser is a class that is instantiated with a markdown flavor. The flavor is a set of parsers, each of which is
responsible for parsing a specific element of the markdown. Once instantiated, you can call the `parse` method with a
markdown string, and it will return the parsed result.

```php
$parser = new AntonioPrimera\Md\Parser(new MyCustomFlavor());
$html = $parser->parse($markdown);
```

## Flavors

A flavor is nothing more than a parser itself, containing:
1. A Splitter: a simple class, with a single method, responsible for splitting the markdown into an array of blocks
2. A set of Node Parsers: each of which is responsible for parsing a specific element of the markdown, like a heading, a paragraph, a code block etc.
3. A set of Inline Parsers: each of which is responsible for parsing a specific inline element, like a link, an image, a bold text etc.
4. A configuration array, that contains the configuration for the flavor and for the parsers used by the flavor.

The concept is that: after the markdown is split into blocks, each block is parsed AND a block can be parsed by a single NodeParser,
but will be parsed by all InlineParsers. For example a paragraph block can be parsed by a ParagraphNodeParser, but the text inside
the paragraph will be parsed by all InlineParsers (parsing links, images, bold text etc).

Here is an example of a custom flavor, and how to use it to parse a markdown string:

```php
class MyCustomMarkdownFlavor
{
	
	public static function create(): MarkdownFlavor
	{
		return new MarkdownFlavor(
			splitter: new NewLineMarkdownSplitter(),
			nodeParsers: [
				'heading' => new HeadingNodeParser(),
				'paragraph' => new ParagraphNodeParser(),
			],
			inlineParsers: [
				'bold' => new BoldInlineParser(),
				'italic' => new ItalicInlineParser(),
				'link' => new LinkInlineParser(),
				'image' => new ImageParser(),
			],
			config: [
			    //this will be passed to the HeadingNodeParser after instantiation
			    'heading' => [
			        'base_level' => 3,  //one hashtag will be h3, two hashtags will be h4 etc
                ],
                //this will be passed to the ParagraphNodeParser after instantiation
                'paragraph' => [
                    'class' => 'paragraph',             //the class for the paragraph tag
                    'empty-class' => 'empty-paragraph', //the class for the paragraph tag, if it's empty
                ],
                //... other configuration options
            ],
		);
	}
}

//then, in your code, you can use it like this:
$parser = AntonioPrimera\Md\Parser::create(MyCustomMarkdownFlavor::create());
$html = $parser->parse($markdown);
```

## Node Parsers

A Node Parser is a class that inherits the `AntonioPrimera\Md\AbstractNodeParser` class. It has 2 methods, one checking
whether the node is a match for this parser and should be processed by it, and the other one, that actually processes the node.

If a node is matched by the `matches` method, the `parse` method will be used to parse it. Once the node is matched and
parsed by a Node Parser, it will stop being processed by other Node Parsers and will be passed to the Inline Parsers.

A simple Node Parser that parses a paragraph block would look like this:

```php
class ParagraphNodeParser extends AbstractNodeParser
{
	public function matches(string $part): bool
	{
		return true;
	}
	
	public function parse(string $text): string|null
	{
		return '<p>' . trim($text) . '</p>';
	}
}
```

## Inline Parsers

An Inline Parser is a class that inherits the `AntonioPrimera\Md\AbstractInlineParser` class. It has a single `parse` method,
that is used to find and replace (parse) inline elements inside the given block. A block is parsed sequentially by all Inline Parsers,
so if an Inline Parser finds an inline element, it will be replaced by the parser and the block will be passed to the next Inline Parser.

A simple Inline Parser that parses a bold text (inline blocks like: ** bold text **) would look like this:

```php
class BoldInlineParser extends AbstractInlineParser
{
	public function parse(string $text): string|null
	{
		return preg_replace_callback('/\*\*(.+)\*\*/s', fn($matches) => "<strong>$matches[1]</strong>", $text);
	}
}
```

## Splitter

A Markdown Splitter is a class that extends the `AntonioPrimera\Md\AbstractMarkdownSplitter` class. It has a single `split` method,
that receives a markdown string and returns an array of blocks. The blocks are then parsed by the Node Parsers and the Inline Parsers.

The default splitter is as simple as this:

```php
class NewLineAbstractMarkdownSplitter extends AbstractMarkdownSplitter
{
	public function split(string|null $text): array
	{
		return $text ? explode("\n", $text) : [];
	}
}
```

## Configuration

When creating and instantiating the flavor, the parsers can receive their specific configuration options as a constructor argument.
Additionally, the flavor itself can have its own configuration options, that can be forwarded to the parsers after instantiation.

This can be done in order to keep the configuration in one place or to allow for dynamic configuration (e.g. based on some user
input stored in the DB).

## Contributing

What still needs to be done:
- optimising the parser (maybe benchmarking it and finding the bottlenecks)
- adding more tests
- adding more node parsers (like a code block parser, a list parser, code parser etc)
- adding more inline parsers (like a hero-icon parser, an image parser etc.)
- making this documentation better

If you want to contribute, feel free to fork the repository and submit a pull request. If you have any questions, feel free to ask.