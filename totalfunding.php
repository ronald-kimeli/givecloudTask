<?php

$startDate = '2023-04-01';
$endDate = '2023-04-08';


/**
 * Finds weeks by two dates
 * @param $startDate
 * @param $endDate
 * @return array
 */
 
function findWeeksBetweenTwoDates($startDate, $endDate)
{
	$weeks = [];
	while (strtotime($startDate) <= strtotime($endDate)) {
		$oldStartDate = $startDate;
		$startDate = date('Y-m-d', strtotime('+7 day', strtotime($startDate)));
		if (strtotime($startDate) > strtotime($endDate)) {
                $week = [$oldStartDate, $endDate]; 
		}
        
		else {
                $week = [$oldStartDate, date('Y-m-d', strtotime('-1 day', strtotime($startDate))) ];			
		}

		$weeks[] = $week;
     
	}

	return $weeks;
}



function daysBetween($startDate, $endDate) {
    return date_diff(
        date_create($endDate),  
        date_create($startDate)
    )->format('%a');
}

print_r(daysBetween($startDate, $endDate));
print_r(findWeeksBetweenTwoDates($startDate, $endDate));

?>