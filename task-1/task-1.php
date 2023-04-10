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
  array_map(
    fn ($element): int => isset($element) && !empty($element) && is_numeric($element) ? intval($element) : 9,
    $arr
  )
);
