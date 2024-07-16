<?php

test('it can map through an array and preserve the keys', function() {
	$array = ['a' => 1, 'b' => 2, 'c' => 3];
	$result = arrayMap($array, fn($value) => $value * 2);
	
	expect($result)->toBe(['a' => 2, 'b' => 4, 'c' => 6]);
});

test('it can map through an array and change the keys and the values', function() {
	$array = ['a' => 1, 'b' => 2, 'c' => 3];
	$result = arrayMapWithKeys($array, fn($value, $key) => [$key . '-updated' => $value * 2]);
	
	expect($result)->toBe(['a-updated' => 2, 'b-updated' => 4, 'c-updated' => 6]);
});

test('it can trim the strings from the items by just providing the trim function', function () {
	$array = [" a \n", "\n b  ", " c "];
	$result = arrayMap($array, fn($value) => trim($value));
	
	expect($result)->toBe(['a', 'b', 'c']);
});