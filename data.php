<?php
$links = array('supporters','recurringsupporter','cancelledsupporters','contributions');

$userid = $_POST['userid']; 

require_once("src/pages/$userid.php");
