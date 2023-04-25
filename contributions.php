<?php
require_once('./src/rest.inc.php');
require_once('./src/config.php');
require_once('./src/functions.php');

$URL = 'https://utcatholic.givecloud.co/admin/api/v2/contributions';
$Headers = array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $Token");

$page = 1; //we are starting from the first page
// GET
$response = RestCurl::get($URL, $Headers, array('page' => $page));
// Lets get total pages from meta
$total_pages = $response['data']->meta->last_page;

$contributions = getData($total_pages,$page,$URL,$Headers);

foreach($contributions as $data){
    $email = $data->email;
    $email = $data->supporter->email;
    $email = mysqli_real_escape_string($conn,$email);
    $supporter_id = mysqli_real_escape_string($conn,$data->supporter->id);
    $supporter_deprecated_id = mysqli_real_escape_string($conn,$data->supporter->id_deprecated);
    $contribution_id = mysqli_real_escape_string($conn,$data->id);
    $contribution_number = mysqli_real_escape_string($conn,$data->contribution_number);
    $total_amount = mysqli_real_escape_string($conn,$data->total_amount);
    $is_paid = mysqli_real_escape_string($conn,$data->is_paid);
    $is_recurring = mysqli_real_escape_string($conn,$data->line_items[0]->is_recurring);

        $insertquery = "INSERT INTO contributions(email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring) 
                            VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring'); ";
        mysqli_multi_query($conn, $insertquery);
        print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
        
}




