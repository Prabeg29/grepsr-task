<?php

declare(strict_types=1);

/**
 * Write a code or function to convert the string and display date in the provided format?
 * a. ‘October 10 2021' to '10102021’ format
 * b. ‘1st November 2022’ to ‘01/11/2022’ format
 */

function convertDateA(string $dateString): string
{
  return DateTime::createFromFormat('F d Y', $dateString)->format('dmY');
}

function convertDateB(string $dateString): string
{
  return DateTime::createFromFormat('jS F Y', $dateString)->format('d/m/Y');
}

echo convertDateA('October 10 2021') . PHP_EOL;
echo convertDateB('1st November 2022');
