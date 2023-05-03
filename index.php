<?php

$links = array('supporters','recurringsupporter','cancelledsupporters','contributions');

foreach($links as $names)
{
   $linkname .= "<button  id='{$names}' class='btn btn-sm dropdown-item '>{$names}</button>";
}

require_once('src/components/header.php');

?>



