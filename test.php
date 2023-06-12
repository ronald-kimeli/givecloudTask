#!/usr/bin/php 
<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once('src/config.php');
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');

$mail = new PHPMailer(true);

//Add to array
$ReceiverEmails = ['kimeliryans@gmail.com'];
$company_name = 'Givecloud';

$first_name = 'NeonPHPMailer';
$last_name = 'Ray';
$email = "test@gmail.com";
$supporter_id = '36326235';
$created_at = "31/02/2023";

$newOrexisting = '';

$mail_template = "
                    <html>
                    <body>
                        <p>Hi,<br>
                        Notification sent to your email concerning <br>
                        The recurring supporter <strong>$first_name $last_name</strong>  <br>
                            with supporter id <strong>{$supporter_id}</strong> and email <strong>{$email}</strong>   added on {$created_at}<br>
                            {$newOrexisting}
                            Go to your website http://173.255.245.185/givecloud/ to track the change<hr>
                         Keep checking your email for new notifications!
                        </p>
                    </body>
                    </html>
                  ";
                  
function sendNotification($mail, $ReceiverEmails, $mail_password, $mail_template, $SMTP_username, $company_name)
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

    foreach($ReceiverEmails as $data){
        $mail->addAddress($data);
    }

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = "New recurring supporter Givecloud Notification";
    $mail->Body = $mail_template;
    
    $mail->send();
    // echo 'Message has been sent';
}

    sendNotification($mail, $ReceiverEmails, $mail_password, $mail_template, $SMTP_username, $company_name);

?>