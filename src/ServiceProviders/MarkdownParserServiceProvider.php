<?php
namespace AntonioPrimera\Md\ServiceProviders;

use AntonioPrimera\Md\MarkdownFlavors\ConfiguredMarkdownParser;
use Illuminate\Support\ServiceProvider;

class MarkdownParserServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		//merge the default config with the user's config
		$this->mergeConfigFrom(__DIR__.'/config/md-parser.php', 'md-parser');
		
		//create a singleton instance of the Parser class, using the factory class defined in the config
		$this->app->singleton('md-parser', function($app){
			$factory = $app->make('config')->get('md-parser.flavor.factory', ConfiguredMarkdownParser::class);
			return $factory === ConfiguredMarkdownParser::class
				? $factory::create()
				: $factory::create($app->make('config')->get('md-parser.flavor.config', []));
		});
	}
	
	public function boot(): void
	{
		$this->publishes([
			__DIR__.'/config/md-parser.php' => config_path('md-parser.php'),
		], 'md-config');
	}
}