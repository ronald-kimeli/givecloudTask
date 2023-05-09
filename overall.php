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



// $contribution = [];

$onetimeArray = [];
$weeklyArray = [];
$monthlyArray = [];

foreach ($contributions as $data) {
    $email = $data['email'];
    $billing_period = $data['billing_period'];

    if ($billing_period == 'onetime') {
        $totaldonation = (int) $data['total_amount'];
            $onetimeArray[]= ['email' => $email,'total_amount' => $totaldonation];
    }

    elseif ($billing_period == 'weekly') {
        $recurring_amount = (int) $data['recurring_amount'];

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
                $weeklyArray[]= ['email' => $email,'total_amount' => $totaldonation];
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[]= ['email' => $email,'total_amount' => $totaldonation];
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
                $weeklyArray[]= ['email' => $email,'total_amount' => $totaldonation];
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[]= ['email' => $email,'total_amount' => $totaldonation];
            }
        }
    }
    else{
        $recurring_amount =  (int) $data['recurring_amount'];

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
                $monthlyArray[]=  (float) ['email' => $email,'total_amount' => $totaldonation];
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[]=  (float) ['email' => $email,'total_amount' => $totaldonation];
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
                $monthlyArray[]= ['email' => $email,'total_amount' => $totaldonation];
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[]= ['email' => $email,'total_amount' => $totaldonation];
            }
        }
    }
}

$c = array_merge_recursive($onetimeArray,$weeklyArray, $monthlyArray);

echo "<pre>";
print_r($c);
echo "</pre>";