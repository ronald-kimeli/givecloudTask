<?php
require_once('src/config.php');
require_once('src/functions.php');
header('Content-Type: application/json; charset=utf-8');

$contributions = mysqli_query($conn, "SELECT recurring_amount,sum(total_amount) AS total_amount,email, billing_period FROM contributions GROUP BY email,billing_period ");

// $fp = fopen('books.csv', 'w');

// while($row = mysqli_fetch_assoc($contributions))
// {
//     fputcsv($fp, $row);
// }

// fclose($fp);



$contribution = [];
foreach ($contributions as $data) {
    $email = $data['email'];
    $billing_period = $data['billing_period'];

    if ($billing_period == 'onetime') {
        $totaldonation = $data['total_amount'];
        // $contribution['email'] = $email;
        // $contribution['billing_period'] = $billing_period;
            $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
        // print_r($totaldonation.$email);
        // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
        // mysqli_multi_query($conn, $insertquery);
    }

    elseif ($billing_period == 'weekly') {
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

            if ($payweeks == 0 && $startDate) {
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            }

        } elseif (mysqli_num_rows($emailreccuring) > 0 && !mysqli_num_rows($emailcancelled) > 0) {
            //Only recurring
            $endDate = strtotime("now");
            $endDate = gmdate("Y-m-d", $endDate);
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where email='$email'");
            $startDate = mysqli_fetch_row($rowcreated)[0];
            $weeks = findWeeksBetweenTwoDates($startDate, $endDate);
            $payweeks = getPayWeekly($weeks);

            if ($payweeks == 0 && $startDate) {
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            }
        }
    }
    // if ($billing_period == 'monthly') 
    else{
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

            if ($paymonths == 0 && $startDate) {
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];

                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
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

            if ($paymonths == 0 && $startDate) {
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $contribution[]= ['email' => $email,'total_amount' => [$totaldonation]];
                // $contribution['email'] = $email;
                // $contribution['billing_period'] = $billing_period;
                // $contribution['total_amount'] = $totaldonation;
                // $insertquery="UPDATE supporters SET total_amount='$totaldonation' WHERE email='$email'";
                // mysqli_multi_query($conn, $insertquery);
            }
        }
    }
}

// $total =0;
// foreach ($contribution as $row) {
//     $email = $row['email'];
//     if($email == 'michael.r.alonzo@gmail.com'){
//         $total += $row['total_amount'];
//     }
    
// }

// // echo '<pre>';
echo json_encode($contribution);

// $outer_array = array();
// $unique_array = array();
// foreach($contribution as $key => $value)
// {
//     $inner_array = array();

//     $fid_value = $value['email'];
//     if(!in_array($value['email'], $unique_array))
//     {
//             array_push($unique_array, $fid_value);
//             // unset($value['email']);
//             array_push($inner_array, $value);
//             $outer_array[$fid_value] = $inner_array;


//     }else{
//             // unset($value['email']);
//             array_push($outer_array[$fid_value], $value);

//     }
// }
// var_dump(array_values($outer_array));


// // print_r($contribution);

// // print_r($newArray);

// foreach ($contribution as $k=>$v) {

//     if (is_array($v)) {
//         $aWhere[] = $k . ' in ('.implode(', ',$v).')';
//     }
//     else {
//         $aWhere[] = $k . ' = ' . $v;
//     }
//  }

//  print_r($aWhere);