<?php

/**
 * Write a code using Regex, to solve problem listed:
 * a. Provided String: “abc@grepsr.com”
 * b. Create an array with three values. Example: [‘abc’, ’grepsr’, ‘com’]
 * c. Ref: https://regex101.com/ (Try/Test)
*/

$string = 'abc@grepsr.com';
$regexToSplitBy = '/[@.]/';
$resultantArray = preg_split($regexToSplitBy, $string);

print_r($resultantArray); // ['abc', 'grepse', 'com']