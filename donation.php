<?php
require_once('src/config.php');
require_once('src/functions.php');

$contributions = mysqli_query($conn, "SELECT recurring_amount,sum(total_amount) AS total_amount,supporter_id, billing_period FROM contributions GROUP BY supporter_id,billing_period ");

$onetimeArray = array();
$weeklyArray = array();
$monthlyArray = array();

foreach ($contributions as $data) {
    $supporter_id = $data['supporter_id'];
    $billing_period = $data['billing_period'];

    if ($billing_period == 'onetime') {
        $totaldonation = (float) $data['total_amount'];
        $onetimeArray[$supporter_id] = $totaldonation;
    }

    if ($billing_period == 'weekly') {
        $recurring_amount = (float) $data['recurring_amount'];

        $supporter_idreccuring = mysqli_query($conn, "SELECT supporter_id FROM recurringsupporters where supporter_id='$supporter_id'");
        $supporter_idcancelled = mysqli_query($conn, "SELECT supporter_id FROM cancelledSupporters where supporter_id='$supporter_id'");
        if (mysqli_num_rows($supporter_idreccuring) > 0 && mysqli_num_rows($supporter_idcancelled) > 0) {
            //Cancelled Recurring
            $rowcancelled = mysqli_query($conn, "SELECT created_at FROM cancelledSupporters where supporter_id='$supporter_id'");
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where supporter_id='$supporter_id'");

            $startDate = mysqli_fetch_row($rowcreated)[0];
            $endDate = mysqli_fetch_row($rowcancelled)[0];
            $weeks = findWeeksBetweenTwoDates($startDate, $endDate);
            $payweeks = getPayWeekly($weeks);

            if ($payweeks == 0 && $startDate) {
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[$supporter_id] = $totaldonation;
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[$supporter_id] = $totaldonation;
            }

        }

        if (mysqli_num_rows($supporter_idreccuring) > 0 && !mysqli_num_rows($supporter_idcancelled) > 0) {
            //Only recurring
            $endDate = strtotime("now");
            $endDate = gmdate("Y-m-d", $endDate);
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where supporter_id='$supporter_id'");
            $startDate = mysqli_fetch_row($rowcreated)[0];
            $weeks = findWeeksBetweenTwoDates($startDate, $endDate);
            $payweeks = getPayWeekly($weeks);

            if ($payweeks == 0 && $startDate) {
                $payweeks = 1;
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[$supporter_id] = $totaldonation;
            } else {
                $totaldonation = $payweeks * $recurring_amount;
                $weeklyArray[$supporter_id] = $totaldonation;
            }
        }
    }

    if ($billing_period == 'monthly') {

        $recurring_amount = (float) $data['recurring_amount'];

        $supporter_idreccuring = mysqli_query($conn, "SELECT supporter_id FROM recurringsupporters where supporter_id='$supporter_id'");
        $supporter_idcancelled = mysqli_query($conn, "SELECT supporter_id FROM cancelledSupporters where supporter_id='$supporter_id'");
        if (mysqli_num_rows($supporter_idreccuring) > 0 && mysqli_num_rows($supporter_idcancelled) > 0) {
            //Cancelled Recurring
            $rowcancelled = mysqli_query($conn, "SELECT created_at FROM cancelledSupporters where supporter_id='$supporter_id'");
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where supporter_id='$supporter_id'");

            $startDate = mysqli_fetch_row($rowcreated)[0];
            $endDate = mysqli_fetch_row($rowcancelled)[0];
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            $paymonths = getPayMonths($startDate, $endDate);

            if ($paymonths == 0 && $startDate) {
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[$supporter_id] = $totaldonation;
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[$supporter_id] = $totaldonation;
            }

        } elseif (mysqli_num_rows($supporter_idreccuring) > 0 && !mysqli_num_rows($supporter_idcancelled) > 0) {
            //Only recurring
            $endDate = strtotime("now");
            $endDate = gmdate("Y-m-d", $endDate);
            $rowcreated = mysqli_query($conn, "SELECT created_at FROM supporters where supporter_id='$supporter_id'");
            $startDate = mysqli_fetch_row($rowcreated)[0];
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            $paymonths = getPayMonths($startDate, $endDate);

            if ($paymonths == 0 && $startDate) {
                $paymonths = 1;
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[$supporter_id] = $totaldonation;
            } else {
                $totaldonation = $paymonths * $recurring_amount;
                $monthlyArray[$supporter_id] = $totaldonation;
            }
        }
    }
}

$contributionArray = array_merge_recursive($onetimeArray, $weeklyArray, $monthlyArray);

foreach ($contributionArray as $key => $value) {
    if (is_array($value)) {
        $value = array_sum($value);
        $updatequery = "UPDATE `supporters` SET total_amount='$value' WHERE supporter_id='$key'";
        mysqli_multi_query($conn, $updatequery);
    } else {
        $updatequery = "UPDATE `supporters` SET total_amount='$value' WHERE supporter_id='$key'";
        mysqli_multi_query($conn, $updatequery);
    }
}