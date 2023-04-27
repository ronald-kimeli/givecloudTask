<?php

?>

<thead>
            <tr>
                <th>#</th>
                <th>First_name</th>
                <th>Last_name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
</thead>

<tbody>
    <?php
    require_once('./src/config.php');
    
    $headername = 'recurringsupporters Table';

    $linkname = '<a href="index.php" class="btn btn-md btn-primary">recurringsupporters Table</a>';

    $recurringsupporters = mysqli_query($conn, "SELECT * FROM recurringsupporters");
    foreach ($recurringsupporters as $data) {
        
    $recurringsupporters_data .= '<tr>
                        <td>' . $data['id'] . '</td>
                        <td>' . $data['first_name'] . '</td>
                        <td>' . $data['last_name'] . '</td>
                        <td>' . $data['email'] . '</td>
                        <td>' . $data['status'] . '</td>
                    </tr>'; //Data for display on Web page
    }
    echo $recurringsupporters_data;
    ?>
</tbody>

<tfoot>
            <tr>
                <th>#</th>
                <th>First_name</th>
                <th>Last_name</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
</tfoot>
