<?php
$headername = 'Contributions Table';

$links = array('supporterTable','recurringsupporterTable','cancelledsupporterTable');

foreach($links as $names)
{

   $linkname .= "<a  href='{$names}.php' type='button' class='dropdown-item '>{$names}</a>";
   
}

$linkname;

require_once('src/components/header.php');

require_once('src/pages/contributers.php');

require_once('src/components/footer.php');
?>