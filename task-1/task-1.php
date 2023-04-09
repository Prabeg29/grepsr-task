<?php

declare(strict_types=1);

/**
 * Write a code, using listed PHP functions, with example
 * a. isset()
 * b. empty()
 * c. array_map()
 */

$arr = [2, 4, '', null, '6', '0'];

print_r(
  array_map(fn ($number): int => isset($number) && !empty($number) ? intval($number) : 9, $arr)
);
