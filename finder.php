<?php

if (isset($argv[1]) === false) {
	echo 'No word specified' . PHP_EOL;
	exit(2);
}
$inputWord = $argv[1];

/**
  * @return string[]|array Example for input "apple": ['a' => 1, 'b' => 0, ..., 'p' => 2, ...]
  */
function wordToCountedCharsArray(string $word): array {
	$chars = range('a', 'z');
	$charsInWord = str_split($word);
	$foundCharsInWord = array_fill_keys($chars, 0);
	foreach ($charsInWord as $char) {
		$foundCharsInWord[$char] ++;
	}
	return $foundCharsInWord;
}

/**
 * @var array All words we know
 */
$words = [];

$fp = fopen('words.txt', 'r');
while ($word = fgets($fp)) {
	$word = trim($word);
	$words[$word] = wordToCountedCharsArray($word);
}
fclose($fp);

$inputWordAsChars = wordToCountedCharsArray($inputWord);
$anagrams = [];
foreach ($words as $word => $wordAsChars) {
	$matches = true;
	foreach ($inputWordAsChars as $char => $requiredCount) {
		if ($wordAsChars[$char] !== $requiredCount) {
			$matches = false;
			break;
		}
	}
	if ($matches === true) {
		$anagrams[$word] = $wordAsChars;
		echo 'Found anagram for "' . $inputWord . '": "' . $word . '"' . PHP_EOL;
	}
}

if (count($anagrams) === 0) {
	echo 'No anagrams found' . PHP_EOL;
}