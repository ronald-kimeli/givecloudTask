<?php
$headername = 'cancelledsupporterTable';

$links = array('index','supporterTable','recurringsupporterTable');

foreach($links as $names)
{

   $linkname .= "<a  href='{$names}.php' type='button' class='dropdown-item '>{$names}</a>";
   
}

$linkname;

require_once('src/components/header.php');

require_once('src/pages/cancelledsupporters.php');

require_once('src/components/footer.php');
?>