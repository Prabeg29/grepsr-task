<?php

declare(strict_types=1);

$arr = [2, 4, '', null, '6', '0'];

print_r(
  array_map(fn($number): int => isset($number) && !empty($number) ? intval($number) : 9, $arr)
);