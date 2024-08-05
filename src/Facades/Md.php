<?php
namespace AntonioPrimera\Md\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string parse(string $text)
 */
class Md extends Facade
{
	protected static function getFacadeAccessor(): string
	{
		return 'md-parser';
	}
}