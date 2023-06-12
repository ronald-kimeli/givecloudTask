<?php

require_once('src/config.php');

$headername = 'recurringsupporters Table';

$recurringsupporters = mysqli_query($conn, "SELECT * FROM recurringsupporters");
$recurringsupporters_data = '';

foreach ($recurringsupporters as $data) {

    $recurringsupporters_data .= '<tr>
                    <td>' . $data['id'] . '</td>
                    <td>' . $data['first_name'] . '</td>
                    <td>' . $data['last_name'] . '</td>
                    <td>' . $data['email'] . '</td>
                    <td>' . $data['phone'] . '</td>
                    <td>' . $data['created_at'] . '</td>
                    <td>' . $data['status'] . '</td>
                    <td>' . $data['created_time'] . '</td>
                </tr>'; //Data for display on Web page
}

$table_row = '<tr>
                <th>#</th>
                <th>First_name</th>
                <th>Last_name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created_at</th>
                <th>Status</th>
                <th>Created_Time</th>
              </tr>';

echo '<table id="example" class="table table-striped table-bordered selection-multiple-rows">
    <thead>
    ' . $table_row . '
    </thead>
    <tbody>' . $recurringsupporters_data . '</tbody>
    <tfoot>
    ' . $table_row . '
    </tfoot>
</table>';
