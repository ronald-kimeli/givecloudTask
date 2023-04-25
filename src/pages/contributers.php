<?php

?>

<thead>
    <tr>
        <th>#</th>
        <th>Email</th>
        <th>Supporter_id</th>
        <th>Supporter_deprecated_id</th>
        <th>Contribution_id</th>
        <th>Contribution_number</th>
        <th>Total_amount</th>
        <th>Is_paid</th>
        <th>Is_recurring</th>
    </tr>
</thead>

<tbody>
    <?php
    require_once('./src/config.php');

    $contributions = mysqli_query($conn, "SELECT * FROM contributions");
    foreach ($contributions as $data) {
        $contributions_data .=
                               '<tr>
                               <td>' . $data['id'] . '</td>
                                <td>' . $data['email'] . '</td>
                                <td>' . $data['supporter_id'] . '</td>
                                <td>' . $data['supporter_deprecated_id'] . '</td>
                                <td>' . $data['contribution_id'] . '</td>
                                <td>' . $data['contribution_number'] . '</td>
                                <td>' . $data['total_amount'] . '</td>
                                <td>' . $data['is_paid'] . '</td>
                                <td>' . $data['is_recurring'] . '</td>
                                </tr>';
    }
    
    echo $contributions_data;
    ?>
</tbody>

<tfoot>
    <tr>
        <th>#</th>
        <th>Email</th>
        <th>Supporter_id</th>
        <th>Supporter_deprecated_id</th>
        <th>Contribution_id</th>
        <th>Contribution_number</th>
        <th>Total_amount</th>
        <th>Is_paid</th>
        <th>Is_recurring</th>
    </tr>
</tfoot>