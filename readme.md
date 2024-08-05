# Custom Markdown Parser

This is a highly customizable Markdown parser, that comes with a predefined Markdown flavor, but allows you to easily create any
other Markdown flavor, whether it's a standard one or something you've just invented.

For example, you could create a Markdown flavor that allows you to embed images with an ID (of an object stored in the DB) or a slug,
or maybe a custom tag that allows you to embed a hero-icon by its name. You can even decide that paragraphs should be separated
by a `|` character instead of a newline.

Here are some examples of what you could easily do with this parser:

```markdown
An image:
![This is the alt text for an image for an image determined by a slug](welcome-image)
![This is the alt text for an image with an id, as stored in the DB](840)

A list of items with hero-icons:
## Contact
[heroicon:phone] [+10 (1234) 567 890](tel:+10 1234.567.890)
[heroicon:envelope] [Email me](abc@def.test)

A gallery:
!!![This is the title of the gallery with 3 images](/img/gallery/1.jpg | /img/gallery/2.jpg | /img/gallery/3.jpg)

Or even a special internal link to an article with a slug:
[Read more about this](article:my-article-slug)
```

## Basic Usage (framework-agnostic)

The main parser is a class that is instantiated with a set of inline parsers, a set of block parsers, optionally
a block splitter and also an optional config. Once instantiated, you can call the `parse` method with a
markdown string, and it will return the parsed result.

If you want to use the default flavor, you can do it like this:

```php
$parser = \AntonioPrimera\Md\MarkdownFlavors\BasicMarkdownParser::create();
$html = $parser->parse($markdownString);
```

If you want to create your own parser, or just change the behavior of the default parser, check the Advanced Usage section below.

## Usage in a Laravel Project

If you are using this package in a Laravel project, everything is set up for you, so you can use the `Md` facade like this:

```php
use AntonioPrimera\Md\Facades\Md;

$html = Md::parse($markdownString);
```

By default, the Service Provider for this package will use the configuration from the `config/md-config.php` file, to create
the parser instance. If you want to change the configuration, you can publish the config file by running:

```bash
php artisan vendor:publish --tag=md-config
```

You have 2 main options to build your parser using the config:

1. Provide a `flavor.factory` entry in the config file, containing the class of your factory, that will return a parser instance, and optionally a `flavor.config` entry, containing the configuration that will be passed to the factory.
2. Provide the necessary building blocks for the parser: `flavor.inlineParsers`, `flavor.blockParsers`, `flavor.splitter` (this is optional) and `flavor.config` (this is also optional).

## Advanced Usage

If you want to create your own flavor, you can do it by creating a factory class that returns an `AntonioPrimera\Md\Parser`
instance, loaded with your custom block and inline parsers, or mix and match the existing ones.

Here is how the default flavor is created:

```php
class BasicMarkdownParser
{
	
	public static function create(array $config = []): Parser
	{
		return new Parser(
			inlineParsers: [
				new ImageParser(),	//this has to go before the LinkParser, because it uses a similar syntax
				new LinkParser(),
				new BoldParser(),
				new ItalicParser(),
				new LineBreakParser(),	//this has to go last, because other parsers may use "|" in their syntax
			],
			blockParsers: [
				new HeadingParser(['baseHeadingLevel' => $config['baseHeadingLevel'] ?? 2]),
				new UnorderedListItemParser(),
				new BlockQuoteParser(),
				new ParagraphParser(),
			],
			config: $config
		);
	}
}
```

## Block Parsers

A Block Parser is a class that inherits the `AntonioPrimera\Md\BlockParser` class. It has 2 methods: `matches` for checking
whether the block is a match for this parser and should be processed by it, and `parse` for parsing the block. Once the block
is matched and parsed by a Block Parser, the result will be added to the parsed result and its parsing will stop.

A simple Block Parser that would parse empty lines (blocks that contain only whitespace) would look like this:

```php
class EmptyBlockParser extends BlockParser
{
	public function matches(string $text, array $parsedBlocks = []): bool
	{
	    //this parser will match empty blocks (blocks that contain only whitespace)
		return empty(trim($text));
	}
	
	public function parse(string $text, array &$parsedBlocks = []): string|MarkdownBlock|null
	{
	    //instead of returning an empty string, we return a special class that will be styled with CSS
		return '<p class="empty-block"></p>';
	}
}
```

## Inline Parsers

An Inline Parser is a class that inherits the `AntonioPrimera\Md\InlineParser` class. It has a single `parse` method,
that is used to find and replace inline elements in the given text. The parser first runs all the Inline Parsers on the
text, and then splits the text into blocks and runs the Block Parsers on each block.

A simple Inline Parser that parses a hero-icon syntax like `[heroicon:icon-name]` would look like this:

```php
class HeroIconParser extends InlineParser
{
	public function parse(string $text): string
    {
        $pattern = '/\[heroicon:(.+)\]/';
        return preg_replace_callback($pattern, fn($matches) => "<i class='heroicon heroicon-$matches[1]'></i>", $text);
    }
}
```

## Splitter

A Markdown Splitter is a class that extends the `AntonioPrimera\Md\Splitters\MarkdownSplitter` class. It has a single
`split` method, that receives a markdown string and returns an array of blocks. The blocks are then parsed by the Block Parsers.

When instantiating the parser, you can pass a Splitter instance, if you rolled your own, or you can pass just a string
that will be used as a delimiter for splitting the markdown string into blocks. By default, the Newline character `\n` is used.

## Configuration

When instantiating a parser, you can pass a configuration to each inline parser and block parser instance, or you can just
pass a single configuration array that will be partially forwarded to all the parsers, based on their aliases.

This can be done in order to keep the configuration in one place or to allow for dynamic configuration (e.g. based on some user
input stored in the DB).

Each inline parser and block parser has an alias, which, by default is the kebab-case class base name without the `parser`
suffix (e.g. `HeroIconParser` has an alias of `hero-icon`). You can override the alias method in the parser class if you want
to use a different alias. Then you can pass the configuration for that parser by using the alias as a key in the configuration array.

```php
$parser = new Parser(
    inlineParsers: [new HeroIconParser()],  //and other inline parsers
    blockParsers: [new HeadingParser()],    //and other block parsers
    config: [
        'hero-icon' => ['iconClass' => 'heroicon', 'iconSubset' => 'heroicon-solid'],
        'heading' => ['baseHeadingLevel' => 3]
    ]
);
```

Which is the same as passing the configuration directly to the parser instances:

```php
$parser = new Parser(
    inlineParsers: [new HeroIconParser(['iconClass' => 'heroicon', 'iconSubset' => 'heroicon-solid'])],
    blockParsers: [new HeadingParser(['baseHeadingLevel' => 3])],
);
```

## Contributing

What still needs to be done:
- optimising the parser (maybe benchmarking it and finding the bottlenecks)
- adding more tests
- adding more node parsers (like a code block parser, an ordered list parser etc.)
- adding more inline parsers (like a hero-icon parser etc.)
- making this documentation better

If you want to contribute, feel free to fork the repository and submit a pull request. If you have any questions, feel free to ask.