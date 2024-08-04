<?php

/**
 * Map through an array and return a new array with the keys and values returned by the callback.
 * The callback receives the value and the key of the current item (in this order) and should
 * return an associative array with a single key-value pair. The key will be used as the
 * new key in the resulting array and the value will be used as the new value.
 */
function arrayMapWithKeys(array $array, callable $callback): array
{
	$result = [];
	foreach ($array as $key => $value) {
		$item = $callback($value, $key);
		$newKey = array_key_first($item);
		$result[$newKey] = $item[$newKey];
	}
	
	return $result;
}

/**
 * Map through an array and return a new array with the values returned by the callback.
 * The callback receives the value and the key of the current item (in this order)
 * and should return the new value. The keys are preserved.
 */
function arrayMap(array $array, callable $callback): array
{
	$result = [];
	foreach ($array as $key => $value) {
		$result[$key] = $callback($value, $key);
	}
	
	return $result;
}

function kebabCase(string $string): string
{
	return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $string));
}

function classBasename(mixed $classOrObject): string
{
	$class = is_object($classOrObject) ? get_class($classOrObject) : $classOrObject;
	return basename(str_replace('\\', '/', $class));
}

function debug(mixed $value): void
{
	file_put_contents(__DIR__ . '/../debug.txt', print_r($value, true), FILE_APPEND);
}