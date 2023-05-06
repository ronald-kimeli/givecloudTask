<?php
require_once('src/config.php');
require_once('src/functions.php');

$contributions = mysqli_query($conn, "SELECT recurring_amount,total_amount,email, billing_period FROM contributions");

foreach ($contributions as $data) {
    $email = $data['email'];
    $billing_period = $data['billing_period'];


    if ($billing_period == 'onetime') {
        $totaldonation = $data['total_amount'];
        // print_r($total_amount.$email);
        $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
        mysqli_multi_query($conn, $insertquery);
    }

    if ($billing_period == 'weekly') {
        $recurring_amount = $data['recurring_amount'];

        $emailreccuring = mysqli_query($conn, "SELECT email FROM recurringsupporters where email='$email'");
        $emailcancelled = mysqli_query($conn, "SELECT email FROM cancelledSupporters where email='$email'");
        if (mysqli_num_rows($emailreccuring) > 0 && mysqli_num_rows($emailcancelled) > 0) {
            //Cancelled Recurring
            $rowcancelled = mysqli_query($conn, "SELECT created_at FROM cancelledSupporters where email='$email'");
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where email='$email'");

            $startDate = mysqli_fetch_row($rowcreated)[0];
            $endDate = mysqli_fetch_row($rowcancelled)[0];
            $weeks = findWeeksBetweenTwoDates($startDate, $endDate);
            $payweeks = getPayWeekly($weeks);
            
            if($payweeks == 0 && $startDate){
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }else{
                $totaldonation = $payweeks * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }
            
        } elseif (mysqli_num_rows($emailreccuring) > 0 && !mysqli_num_rows($emailcancelled) > 0) {
            //Only recurring
            $endDate = strtotime("now");
            $endDate = gmdate("Y-m-d", $endDate);
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where email='$email'");
            $startDate = mysqli_fetch_row($rowcreated)[0];
            $weeks = findWeeksBetweenTwoDates($startDate, $endDate);
            $payweeks = getPayWeekly($weeks);
            
            if($payweeks == 0 && $startDate){
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }else{
                $totaldonation = $payweeks * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }
        }
    }

    if ($billing_period == 'monthly') {
        $recurring_amount = $data['recurring_amount'];
        
        $emailreccuring = mysqli_query($conn, "SELECT email FROM recurringsupporters where email='$email'");
        $emailcancelled = mysqli_query($conn, "SELECT email FROM cancelledSupporters where email='$email'");
        if (mysqli_num_rows($emailreccuring) > 0 && mysqli_num_rows($emailcancelled) > 0) {
            //Cancelled Recurring
            $rowcancelled = mysqli_query($conn, "SELECT created_at FROM cancelledSupporters where email='$email'");
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where email='$email'");

            $startDate = mysqli_fetch_row($rowcreated)[0];
            $endDate = mysqli_fetch_row($rowcancelled)[0];
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            $paymonths = getPayMonths($startDate, $endDate);
                        
            if($paymonths == 0 && $startDate){
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }else{
                $totaldonation = $paymonths * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }
            
        } elseif (mysqli_num_rows($emailreccuring) > 0 && !mysqli_num_rows($emailcancelled) > 0) {
            //Only recurring
            $endDate = strtotime("now");
            $endDate = gmdate("Y-m-d", $endDate);
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where email='$email'");
            $startDate = mysqli_fetch_row($rowcreated)[0];
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            $paymonths = getPayMonths($startDate, $endDate);
                        
            if($paymonths == 0 && $startDate){
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }else{
                $totaldonation = $paymonths * $recurring_amount;
                $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                mysqli_multi_query($conn, $insertquery);
            }
        }
    }
}


