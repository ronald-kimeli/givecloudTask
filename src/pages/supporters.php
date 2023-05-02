<?php

require_once('src/config.php');

$headername = 'supporter Table';

$supporters = mysqli_query($conn, "SELECT * FROM supporters");

$supporters_data = '';
foreach ($supporters as $data) {

    $supporters_data .= '<tr>
                    <td>' . $data['id'] . '</td>
                    <td>' . $data['supporter_id'] . '</td>
                    <td>' . $data['first_name'] . '</td>
                    <td>' . $data['last_name'] . '</td>
                    <td>' . $data['email'] . '</td>
                    <td>' . $data['status'] . '</td>
                </tr>
                '; //Data for display on Web page
}
    
echo '<table id="example" class="table table-striped table-bordered selection-multiple-rows">
    <thead>
        <tr>
            <th>#</th>
            <th>Supporter_id</th>
            <th>First_name</th>
            <th>Last_name</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>'.$supporters_data.'</tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Supporter_id</th>
            <th>First_name</th>
            <th>Last_name</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </tfoot>
</table>';

?>

