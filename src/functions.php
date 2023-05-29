<?php

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function saveSupporters($total_pages,$page,$Headers,$conn){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $supporters = $response['data']->data;
            for($row = 0; $row < count($supporters); $row++){ 
                $supporter_id = mysqli_real_escape_string($conn,$supporters[$row]->id);
                $first_name = mysqli_real_escape_string($conn,$supporters[$row]->first_name);
                $last_name = mysqli_real_escape_string($conn,$supporters[$row]->last_name);
                $email = mysqli_real_escape_string($conn,$supporters[$row]->email);
                $phone = mysqli_real_escape_string($conn,$supporters[$row]->billing_address->phone);
                $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($supporters[$row]->created_at)));
                $status = mysqli_real_escape_string($conn,$supporters[$row]->active);
            
                    $insertquery = "INSERT IGNORE INTO `supporters` (supporter_id,first_name,last_name,email,phone,created_at,status) 
                    VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}";
            $response = RestCurl::get($URL, $Headers);
            $supporters = $response['data']->data;
            for($row = 0; $row < count($supporters); $row++){ 
                $supporter_id = mysqli_real_escape_string($conn,$supporters[$row]->id);
                $first_name = mysqli_real_escape_string($conn,$supporters[$row]->first_name);
                $last_name = mysqli_real_escape_string($conn,$supporters[$row]->last_name);
                $email = mysqli_real_escape_string($conn,$supporters[$row]->email);
                $phone = mysqli_real_escape_string($conn,$supporters[$row]->billing_address->phone);
                $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($supporters[$row]->created_at)));
                $status = mysqli_real_escape_string($conn,$supporters[$row]->active);
            
                    $insertquery = "INSERT IGNORE INTO `supporters` (supporter_id,first_name,last_name,email,phone,created_at,status) 
                    VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}


function saveContributions($total_pages,$page,$Headers,$conn){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $contributions = $response['data']->data;
            for($row = 0; $row < count($contributions); $row++){ 
                $email = @$contributions[$row]->email;
                $email = @$contributions[$row]->supporter->email;
                $email = mysqli_real_escape_string($conn,$email);
                
                $supporter_id = mysqli_real_escape_string($conn,@$contributions[$row]->supporter->id);
                $supporter_deprecated_id = mysqli_real_escape_string($conn,@$contributions[$row]->supporter->id_deprecated);
                $contribution_id = mysqli_real_escape_string($conn,$contributions[$row]->id);
                $contribution_number = mysqli_real_escape_string($conn,$contributions[$row]->contribution_number);
                $total_amount = mysqli_real_escape_string($conn,$contributions[$row]->total_amount);
                $is_paid = mysqli_real_escape_string($conn,$contributions[$row]->is_paid);
               
                    $lineitems = $contributions[$row]->line_items;
                    for($lineitem = 0; $lineitem < count($lineitems); $lineitem++){ 
                        
                        $is_recurring = mysqli_real_escape_string($conn,$lineitems[$lineitem]->is_recurring);
                        $recurring_description = mysqli_real_escape_string($conn,$lineitems[$lineitem]->recurring_description);
                        
                        if(empty($recurring_description)){
                            $date_started = '';
                        }else{
                            $date_started = find_date($recurring_description);
                            $date_started = mysqli_real_escape_string($conn, implode('-', $date_started));
                        } 
                                           
                        $recurring_amount = mysqli_real_escape_string($conn,$lineitems[$lineitem]->recurring_amount);
                        
                        $billing_period = mysqli_real_escape_string($conn,$lineitems[$lineitem]->variant->billing_period);
                    }

                    $insertquery = "INSERT IGNORE INTO contributions(email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring,date_started,recurring_amount,billing_period) 
                                        VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring', '$date_started', '$recurring_amount', '$billing_period'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$page}";
            $response = RestCurl::get($URL, $Headers);
            $contributions = $response['data']->data;
            for($row = 0; $row < count($contributions); $row++){ 
                $email = @$contributions[$row]->email;
                $email = @$contributions[$row]->supporter->email;
                $email = mysqli_real_escape_string($conn,$email);
                
                $supporter_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id);
                $supporter_deprecated_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id_deprecated);
                $contribution_id = mysqli_real_escape_string($conn,$contributions[$row]->id);
                $contribution_number = mysqli_real_escape_string($conn,$contributions[$row]->contribution_number);
                $total_amount = mysqli_real_escape_string($conn,$contributions[$row]->total_amount);
                $is_paid = mysqli_real_escape_string($conn,$contributions[$row]->is_paid);
                
                    $lineitems = $contributions[$row]->line_items;
                    for($lineitem = 0; $lineitem < count($lineitems); $lineitem++){ 
                        
                        $is_recurring = mysqli_real_escape_string($conn,$lineitems[$lineitem]->is_recurring);
                        $recurring_description = mysqli_real_escape_string($conn,$lineitems[$lineitem]->recurring_description);
                        
                        if(empty($recurring_description)){
                            $date_started = '';
                        }else{
                            $date_started = find_date($recurring_description);
                            $date_started = mysqli_real_escape_string($conn, implode('-', $date_started));
                        } 
                                        
                        $recurring_amount = mysqli_real_escape_string($conn,$lineitems[$lineitem]->recurring_amount);
                        
                        $billing_period = mysqli_real_escape_string($conn,$lineitems[$lineitem]->variant->billing_period);
                    }

                    $insertquery = "INSERT IGNORE INTO contributions(email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring,date_started,recurring_amount,billing_period) 
                                        VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring', '$date_started', '$recurring_amount', '$billing_period'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
    }
}

function saverecurringsupporters($total_pages,$page,$Headers,$conn,$profile,$mail_password){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $recurringsupporters = $response['data']->data;
            for($row = 0; $row < count($recurringsupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$recurringsupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$recurringsupporters[$row]->email);
                    $phone = mysqli_real_escape_string($conn,$recurringsupporters[$row]->billing_address->phone);
                    $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($recurringsupporters[$row]->created_at)));
                    $status = mysqli_real_escape_string($conn,$recurringsupporters[$row]->active);
                    
                    
                    if(ifNotExists($conn, $supporter_id)){
                        $note_email = 'kimeliryans@gmail.com';
                        $company_name = 'Givecloud Notification';
                        $username = 'Ronald';
                        
                        $insertquery = "INSERT IGNORE INTO `recurringsupporters` (supporter_id, first_name, last_name, email, phone, created_at, status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                             
                        sendEmailNotification($username, $note_email, $supporter_id, $company_name, $created_at, $last_name,$first_name, $mail_password);
                    }
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $recurringsupporters = $response['data']->data;
            for($row = 0; $row < count($recurringsupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$recurringsupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$recurringsupporters[$row]->email);
                    $phone = mysqli_real_escape_string($conn,$recurringsupporters[$row]->billing_address->phone);
                    $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($recurringsupporters[$row]->created_at)));
                    $status = mysqli_real_escape_string($conn,$recurringsupporters[$row]->active);
                    
                    if(ifNotExists($conn, $supporter_id)){
                        $note_email = 'kimeliryans@gmail.com';
                        $company_name = 'Givecloud Notification';
                        $username = 'Ronald';
                        
                        $insertquery = "INSERT IGNORE INTO `recurringsupporters` (supporter_id, first_name, last_name, email, phone, created_at, status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                             
                        sendEmailNotification($username, $note_email, $supporter_id, $company_name, $created_at, $last_name,$first_name, $mail_password);
                    }
               }

    }
}


function cancelledSupporters($total_pages,$page,$Headers,$conn,$profile){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $cancelledSupporters = $response['data']->data;
            for($row = 0; $row < count($cancelledSupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->email);
                    $phone = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->billing_address->phone);
                    $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($cancelledSupporters[$row]->created_at)));
                    $status = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `cancelledSupporters` (supporter_id,first_name,last_name,email,phone,created_at,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $cancelledSupporters = $response['data']->data;
            for($row = 0; $row < count($cancelledSupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->email);
                    $phone = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->billing_address->phone);
                    $created_at = mysqli_real_escape_string($conn,date('Y-m-d',strtotime($cancelledSupporters[$row]->created_at)));
                    $status = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `cancelledSupporters` (supporter_id,first_name,last_name,email,phone,created_at,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}

function backupDatabaseAllTables($dbhost,$dbusername,$dbpassword,$dbname,$tables = '*'){
    $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname); 

    if($tables == '*') { 
        $tables = array();
        $result = $db->query("SHOW TABLES");
        while($row = $result->fetch_row()) { 
            $tables[] = $row[0];
        }
    } else { 
        $tables = is_array($tables)?$tables:explode(',',$tables);
    }

    $return = '';

    foreach($tables as $table){
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;

        /* $return .= "DROP TABLE $table;"; */
        $result2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $result2->fetch_row();

        $return .= "\n\n".$row2[1].";\n\n";

        for($i = 0; $i < $numColumns; $i++) { 
            while($row = $result->fetch_row()) { 
                $return .= "INSERT INTO $table VALUES(";
                for($j=0; $j < $numColumns; $j++) { 
                    $row[$j] = addslashes($row[$j]);
                    if (isset($row[$j])) { 
                        $return .= '"'.$row[$j].'"' ;
                    } else { 
                        $return .= '""';
                    }
                    if ($j < ($numColumns-1)) {
                        $return.= ',';
                    }
                }
                $return .= ");\n";
            }
        }

        $return .= "\n\n\n";
    }

    // $handle = fopen('your_db_'.time().'.sql','w+');
    // fwrite($handle,$return);
    // fclose($handle);
    
    $file_name = "{$dbname}" . date('y-m-d') . '.sql';
    $file_handle = fopen($file_name, 'w+');
    fwrite($file_handle, $return);
    fclose($file_handle);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);
    echo "Database Export Successfully!";
}


/**
 * Finds weeks by two dates
 * @param $startDate
 * @param $endDate
 * @return array
 */

 function findWeeksBetweenTwoDates($startDate, $endDate)
 {
     $weeks = [];
     while (strtotime($startDate) <= strtotime($endDate)) {
         $oldStartDate = $startDate;
         $startDate = date('Y-m-d', strtotime('+7 day', strtotime($startDate)));
         if (strtotime($startDate) > strtotime($endDate)) {
             $week = [$oldStartDate, $endDate];
         } else {
             $week = [$oldStartDate, date('Y-m-d', strtotime('-1 day', strtotime($startDate)))];
         }
 
         $weeks[] = $week;
 
     }
 
     return $weeks;
 }
 function daysBetween($startDate, $endDate)
 {
     return date_diff(
         date_create($endDate),
         date_create($startDate)
     )->format('%a');
 }
 
 function getPayWeekly($weeks)
 {
     $count = 0;
     for ($i = 0; $i < count($weeks); $i++):
         $initialDate = $weeks[$i][0];
         $endingDate = $weeks[$i][1];
         if (daysBetween($initialDate, $endingDate) + 1 >= 2) {
             $count++;
         }
     endfor;
 
     return $count;
 }
 function getPayMonths($startDate, $endDate = FALSE)
{
	$endDate OR $endDate = time();
    
	$startDate = new DateTime("@$startDate");
	$endDate   = new DateTime("@$endDate");
	$diff  = $startDate->diff($endDate);

	return $diff->format('%y') * 12 + $diff->format('%m');
}

function ifNotExists($conn, $supporter_id){
    $query_recurring = mysqli_query($conn, "SELECT supporter_id FROM recurringsupporters WHERE supporter_id='$supporter_id'");

    if (mysqli_num_rows($query_recurring) > 0) {
        //Service Ids if exists in database
        return false;
    }else{
        return true;
    }
}

/**
 * Summary of sendEmailNotification
 * @param mixed $gmail
 * @param mixed $company_name
 * @return void
 */
function sendEmailNotification($username, $note_email, $supporter_id, $company_name, $created_at, $last_name,$first_name, $mail_password)
{
  $mail = new PHPMailer(true);

  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->isSMTP();
  $mail->SMTPAuth   = true;  

  $mail->Host       = "smtp.gmail.com";                                             
  $mail->Username   = "leavemanagement254@gmail.com";                     //SMTP username
  $mail->Password   = $mail_password;
                              
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
  $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  //xjssirazbecywkjg
  //Recipients
  
  $mail->setFrom("noreply@givecloud-notification.com", $company_name);
  $mail->addAddress($note_email);     //Add a recipient
  
   //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = "New recurring supporter Givecloud Notification";
  
  $mail_template = "
  <html>
  <body>
      <p>Hi {$username},<br>
        Notification sent to your email concerning <br>
         The supporter <strong>$first_name $last_name</strong> <br>
         recurring supporter id <strong>{$supporter_id}</strong> who was added on {$created_at}<br>
          Go to your website http://173.255.245.185/givecloud/ and search for the id above<hr>
      Keep checking your email for new notification!.
      </p>
  </body>
  </html>
  ";
 
  $mail->Body    = $mail_template;
  $mail->send();
  // echo 'Message has been sent';
}