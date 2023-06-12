#!/usr/bin/php 
<?php

require_once('src/rest.inc.php');
require_once('src/config.php');
require_once('src/functions.php');

$page = 1;
$profile = 'cancelled';

$URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
$Headers = array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $Token");
// GET
$response = RestCurl::get($URL, $Headers);

$data = $response['data']->data; 

// Lets get total pages from meta
$total_pages = $response['data']->meta->last_page;

$cancelledSupporters = cancelledSupporters($total_pages,$page,$Headers,$conn,$profile);





