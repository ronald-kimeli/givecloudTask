<?php

?>

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

<tbody>
    <?php
    require_once('./src/config.php');
    
    $headername = 'cancelledSupporters Table';

    $linkname = '<a href="index.php" class="btn btn-md btn-primary">cancelledSupporters Table</a>';

    $cancelledSupporters = mysqli_query($conn, "SELECT * FROM cancelledSupporters");
    foreach ($cancelledSupporters as $data) {

    $cancelledSupporters_data .= '<tr>
                        <td>' . $data['id'] . '</td>
                        <td>' . $data['supporter_id'] . '</td>
                        <td>' . $data['first_name'] . '</td>
                        <td>' . $data['last_name'] . '</td>
                        <td>' . $data['email'] . '</td>
                        <td>' . $data['status'] . '</td>
                    </tr>'; //Data for display on Web page
    }
    echo $cancelledSupporters_data;
    ?>
</tbody>

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
