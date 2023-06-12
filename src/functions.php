<?php
#!/usr/bin/php

use PHPMailer\PHPMailer\PHPMailer;

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');

$mail = new PHPMailer(true);

function saveSupporters($total_pages, $page, $Headers, $conn)
{
    if ($total_pages > 1) {
        for ($i = $page; $i <= $total_pages; $i++) {
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $supporters = $response['data']->data;
            $table = 'supporters';
            for ($row = 0; $row < count($supporters); $row++) {
                $supporterRow = $supporters[$row];
                $insertquery = $insertquery = processInsertSupporters($conn,$supporterRow,$table);
            mysqli_multi_query($conn, $insertquery);
                mysqli_multi_query($conn, $insertquery);
            }
        }
    } else {
        $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}";
        $response = RestCurl::get($URL, $Headers);
        $supporters = $response['data']->data;
        $table = 'supporters';
        for ($row = 0; $row < count($supporters); $row++) {
            $supporterRow = $supporters[$row];
            $insertquery = $insertquery = processInsertSupporters($conn,$supporterRow,$table);
            mysqli_multi_query($conn, $insertquery);
            mysqli_multi_query($conn, $insertquery);
        }
    }
}


function saveContributions($total_pages, $page, $Headers, $conn, $mail, $ReceiverEmails, $mail_password, $SMTP_username, $company_name)
{
    if ($total_pages > 1) {
        for ($i = $page; $i <= $total_pages; $i++) {
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $contributions = $response['data']->data;
            for ($row = 0; $row < count($contributions); $row++) {
                processContribution($contributions, $mail, $ReceiverEmails, $mail_password, $row, $conn, $SMTP_username, $company_name);
            }
        }
    } else {
        $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$page}";
        $response = RestCurl::get($URL, $Headers);
        $contributions = $response['data']->data;
        for ($row = 0; $row < count($contributions); $row++) {
            processContribution($contributions, $mail, $ReceiverEmails, $mail_password, $row, $conn, $SMTP_username, $company_name);
        }
    }
}

function saverecurringsupporters($total_pages, $page, $Headers, $conn, $profile)
{
    if ($total_pages > 1) {
        for ($i = $page; $i <= $total_pages; $i++) {
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $recurringsupporters = $response['data']->data;
            $table = 'recurringsupporters';
            for ($row = 0; $row < count($recurringsupporters); $row++) {
                $supporterRow = $recurringsupporters[$row];
                $insertquery = processInsertSupporters($conn,$supporterRow,$table);
                mysqli_multi_query($conn, $insertquery);
            }
        }
    } else {
        $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
        $response = RestCurl::get($URL, $Headers);
        $recurringsupporters = $response['data']->data;
        $table = 'recurringsupporters';
        for ($row = 0; $row < count($recurringsupporters); $row++) {
            $supporterRow = $recurringsupporters[$row];
            $insertquery = processInsertSupporters($conn,$supporterRow,$table);
            mysqli_multi_query($conn, $insertquery);
        }
    }
}


function cancelledSupporters($total_pages, $page, $Headers, $conn, $profile)
{
    if ($total_pages > 1) {
        for ($i = $page; $i <= $total_pages; $i++) {
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $cancelledSupporters = $response['data']->data;
            $table = 'cancelledSupporters';
            for ($row = 0; $row < count($cancelledSupporters); $row++) {
                $supporterRow = $cancelledSupporters[$row];
                $insertquery = processInsertSupporters($conn,$supporterRow,$table);
            mysqli_multi_query($conn, $insertquery);
            }
        }
    } else {
        $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
        $response = RestCurl::get($URL, $Headers);
        $cancelledSupporters = $response['data']->data;
        $table = 'cancelledSupporters';
        for ($row = 0; $row < count($cancelledSupporters); $row++) {
            $supporterRow = $cancelledSupporters[$row];
            $insertquery = processInsertSupporters($conn,$supporterRow,$table);
            mysqli_multi_query($conn, $insertquery);
        }
    }
}

function backupDatabaseAllTables($dbhost, $dbusername, $dbpassword, $dbname, $tables = '*')
{
    $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

    if ($tables == '*') {
        $tables = array();
        $result = $db->query("SHOW TABLES");
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    $return = '';

    foreach ($tables as $table) {
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;

        /* $return .= "DROP TABLE $table;"; */
        $result2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $result2->fetch_row();

        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $numColumns; $i++) {
            while ($row = $result->fetch_row()) {
                $return .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numColumns; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($numColumns - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }

        $return .= "\n\n\n";
    }

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
    for ($i = 0; $i < count($weeks); $i++) :
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
    $endDate or $endDate = time();

    $startDate = new DateTime("@$startDate");
    $endDate = new DateTime("@$endDate");
    $diff = $startDate->diff($endDate);

    return $diff->format('%y') * 12 + $diff->format('%m');
}

/**
 * Summary of sending email notification
 * @param mixed $gmail
 * @param mixed $company_name
 * @return void
 */

//check if exists before sending mail

function processIFNewOrNewrecurrOrExistingrecurr($conn, $contribution_id, $supporter_id, $recurrStatus, $email, $supporter_deprecated_id, $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period,$first_name, $last_name, $created_at,$mail, $ReceiverEmails, $mail_password,$SMTP_username, $company_name)
{
    $contribution_query = mysqli_query($conn, "SELECT contribution_id FROM contributions WHERE contribution_id='$contribution_id' LIMIT 1");
    //Check if the supporter is recurring
    $CheckIsrecurr = mysqli_query($conn, "SELECT supporter_id FROM `supporters` WHERE supporter_id='$supporter_id' && recurring_status=1");
    
    if (!mysqli_num_rows($contribution_query) > 0 && $recurrStatus && mysqli_num_rows($CheckIsrecurr)) {
            //Save to database and send email 
            $insert_to_contribution = InsertToContributions($email, $supporter_id, $supporter_deprecated_id, $contribution_id, $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period);
            mysqli_multi_query($conn, $insert_to_contribution);

            $newOrexisting = 'who was previously recurring, has a new recurring status.<br>';
            $mail_template = EmailTemplate($first_name, $last_name, $supporter_id, $email, $created_at, $newOrexisting);
            sendMailNotification($mail, $ReceiverEmails, $mail_password, $mail_template, $SMTP_username, $company_name);
    }elseif (!mysqli_num_rows($contribution_query) > 0 && $recurrStatus && !mysqli_num_rows($CheckIsrecurr)){
            //Save to database and send email 
            $insert_to_contribution = InsertToContributions($email, $supporter_id, $supporter_deprecated_id, $contribution_id,  $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period);
            mysqli_multi_query($conn, $insert_to_contribution);
            
            $newOrexisting = 'is now new to recurring.<br>';
            $mail_template = EmailTemplate($first_name, $last_name, $supporter_id, $email, $created_at, $newOrexisting);
            sendMailNotification($mail, $ReceiverEmails, $mail_password, $mail_template, $SMTP_username, $company_name);
            
            //After Notification update to recurring
            $updatequery = "UPDATE `supporters` SET recurring_status=1 WHERE supporter_id='$supporter_id'";
            mysqli_multi_query($conn, $updatequery);
            
    }elseif(!mysqli_num_rows($contribution_query) > 0) {
            //Just save to database
            $insert_to_contribution = InsertToContributions($email, $supporter_id, $supporter_deprecated_id, $contribution_id,  $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period);
            mysqli_multi_query($conn, $insert_to_contribution);
    }
}

function EmailTemplate($first_name, $last_name, $supporter_id, $email, $created_at, $newOrexisting)
{
    $mail_template = "
                    <html>
                    <body>
                        <p>Hi,<br>
                        Notification sent to your email concerning <br>
                        The recurring supporter <strong>$first_name $last_name</strong>  <br>
                            with supporter id <strong>{$supporter_id}</strong> and email <strong>{$email}</strong>   added on {$created_at}<br>
                            {$newOrexisting}
                            Navigate to http://173.255.245.185/givecloud/ to track the change<hr>
                         Keep checking your email for new notifications!
                        </p>
                    </body>
                    </html>
                  ";
    return $mail_template;
}

function InsertToContributions($email, $supporter_id, $supporter_deprecated_id, $contribution_id,  $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period)
{
    $insert_to_contribution = "INSERT IGNORE INTO contributions (email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring,date_started,recurring_amount,billing_period) 
    VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring', '$date_started', '$recurring_amount', '$billing_period')";

    return $insert_to_contribution;
}


function processContribution($contributions, $mail, $ReceiverEmails, $mail_password, $row, $conn, $SMTP_username, $company_name)
{
    $email = @$contributions[$row]->email;
    $first_name = @$contributions[$row]->supporter->first_name;
    $last_name = @$contributions[$row]->supporter->last_name;
    $created_at = @$contributions[$row]->supporter->created_at;

    $email = mysqli_real_escape_string($conn, $email);

    $supporter_id = mysqli_real_escape_string($conn, @$contributions[$row]->supporter->id);
    $supporter_deprecated_id = mysqli_real_escape_string($conn, @$contributions[$row]->supporter->id_deprecated);
    $contribution_id = mysqli_real_escape_string($conn, $contributions[$row]->id);
    $contribution_number = mysqli_real_escape_string($conn, $contributions[$row]->contribution_number);
    $total_amount = mysqli_real_escape_string($conn, $contributions[$row]->total_amount);
    $is_paid = mysqli_real_escape_string($conn, $contributions[$row]->is_paid);

    $lineitems = $contributions[$row]->line_items;
    for ($lineitem = 0; $lineitem < count($lineitems); $lineitem++) {

        $recurrStatus = $lineitems[$lineitem]->is_recurring;
        $is_recurring = mysqli_real_escape_string($conn, $recurrStatus);
        $recurring_description = mysqli_real_escape_string($conn, $lineitems[$lineitem]->recurring_description);

        if (empty($recurring_description)) {
            $date_started = '';
        } else {
            $date_started = find_date($recurring_description);
            $date_started = mysqli_real_escape_string($conn, implode('-', $date_started));
        }

        $recurring_amount = mysqli_real_escape_string($conn, $lineitems[$lineitem]->recurring_amount);

        $billing_period = mysqli_real_escape_string($conn, $lineitems[$lineitem]->variant->billing_period);
    }
    
    processIFNewOrNewrecurrOrExistingrecurr($conn, $contribution_id, $supporter_id, $recurrStatus, $email, $supporter_deprecated_id, $contribution_number, $total_amount, $is_paid, $is_recurring, $date_started, $recurring_amount, $billing_period,$first_name, $last_name, $created_at,$mail, $ReceiverEmails, $mail_password,$SMTP_username, $company_name);

}


function sendMailNotification($mail, $ReceiverEmails, $mail_password, $mail_template, $SMTP_username, $company_name)
{
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username = $SMTP_username; //SMTP username
    $mail->Password = $mail_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom("noreply@givecloud-notification.com", $company_name);

    foreach ($ReceiverEmails as $data) {
        $mail->addAddress($data);
    }

    //Content
    $mail->isHTML(true);
    $mail->Subject = "New recurring supporter Givecloud Notification";
    $mail->Body = $mail_template;

    $mail->send();
    // echo 'Message has been sent';
}

function processInsertSupporters($conn,$supporterRow,$table){
            $supporter_id = mysqli_real_escape_string($conn,$supporterRow->id);
            $first_name = mysqli_real_escape_string($conn, $supporterRow->first_name);
            $last_name = mysqli_real_escape_string($conn, $supporterRow->last_name);
            $email = mysqli_real_escape_string($conn, $supporterRow->email);
            $phone = mysqli_real_escape_string($conn, $supporterRow->billing_address->phone);
            $created_at = mysqli_real_escape_string($conn, date('Y-m-d', strtotime($supporterRow->created_at)));
            $status = mysqli_real_escape_string($conn, $supporterRow->active);

            $insertquery = "INSERT IGNORE INTO `{$table}` (supporter_id,first_name,last_name,email,phone,created_at,status) 
                VALUES('$supporter_id','$first_name', '$last_name', '$email', '$phone', '$created_at', '$status'); ";
            return $insertquery;
}
