<?php
#!/usr/bin/php

require_once('src/rest.inc.php');
require_once('src/config.php');
require_once('src/functions.php');

//sets timezone
date_default_timezone_set("Africa/Nairobi");

$page = 1; //we are starting from the first page
$profile = 'active';

$URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
$Headers = array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $Token");
// GET
$response = RestCurl::get($URL, $Headers);
$data = $response['data']->data; 

// Lets get total pages from meta
$total_pages = $response['data']->meta->last_page;

$recurringsupporters = saverecurringsupporters($total_pages,$page,$Headers,$conn,$profile,$mail_password);
