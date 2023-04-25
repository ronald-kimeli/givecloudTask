<?php
require_once('./src/rest.inc.php');
require_once('./src/config.php');
require_once('./src/functions.php');

$profile = 'active';

$URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?filter[recurringProfile]={$profile}";
$Headers = array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $Token");

$page = 1; //we are starting from the first page
// GET
$response = RestCurl::get($URL, $Headers, array('page' => $page));
// Lets get total pages from meta
$total_pages = $response['data']->meta->last_page;

$recurringsupporters = getData($total_pages,$page,$URL,$Headers);

$count = 0;
foreach(array_values($recurringsupporters) as $row){
    $count++;
    $supporter_id = mysqli_real_escape_string($conn,$row->id);
    $first_name = mysqli_real_escape_string($conn,$row->first_name);
    $last_name = mysqli_real_escape_string($conn,$row->last_name);
    $email = mysqli_real_escape_string($conn,$row->email);
    $status = mysqli_real_escape_string($conn,$row->active);

        $insertquery = "INSERT INTO `recurringsupporters` (supporter_id,first_name,last_name,email,status) 
        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
        mysqli_multi_query($conn, $insertquery);
        print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
}



