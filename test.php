<?php

require_once('src/function.find_date.php');
// $date = date("d F Y", strtotime(str_replace('starting ','',"$114.02/mth (1st) starting February 1st, 2022")));
// echo $date;

$strx = "$30.00 USD/wk starting Saturday, Feb 13th, 2021";
// $str = " $30.00/Saturday starting Saturday, February 13th, 2021";
// $str1 = "Company registered on 16 March 2003";
// $str2 = "Activity between 10 May 2006 an 10 July 2008 - no changes.";

// print_r(find_date($str1)); // output: 2003-03-16
// print_r(find_date($str2)); // output: ['2006-05-10','2008-07-10']
// print_r(find_date($str));
print_r(find_date($strx));