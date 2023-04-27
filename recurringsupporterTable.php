<?php
$headername = 'recurringsupporterTable';

$links = array('index','supporterTable','cancelledsupporterTable');

foreach($links as $names)
{

   $linkname .= "<a  href='{$names}.php' type='button' class='dropdown-item '>{$names}</a>";
   
}

$linkname;

require_once('src/components/header.php');

require_once('src/pages/recurringsupporter.php');

require_once('src/components/footer.php');
?>
