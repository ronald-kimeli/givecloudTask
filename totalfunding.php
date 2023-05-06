<?php
// require_once('src/functions.php');

$start = strtotime('2023-04-07');
$end = strtotime('2023-05-08');

/**
 * Calculates how many months is past between two timestamps.
 *
 * @param  int $start Start timestamp.
 * @param  int $end   Optional end timestamp.
 *
 * @return int
 */
function getPayMonths($start, $end = FALSE)
{
	$end OR $end = time();

	$start = new DateTime("@$start");
	$end   = new DateTime("@$end");
	$diff  = $start->diff($end);

	return $diff->format('%y') * 12 + $diff->format('%m');
}


print_r(getPayMonths($start, $end));