<?php

/**
 * Write a code or function to convert the string and display date in the provided format?
 * a. ‘October 10 2021' to '10102021’ format
 * b. ‘1st November 2022’ to ‘01/11/2022’ format
 */

function convertDateA(string $date): string
{
  return DateTime::createFromFormat('F d Y', $date)->format('dmY');
}

function convertDateB(string $date): string
{
  return DateTime::createFromFormat('jS F Y', $date)->format('d/m/Y');
}

echo convertDateA('October 10 2021') . PHP_EOL;
echo convertDateB('1st November 2022');
