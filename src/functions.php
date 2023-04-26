<?php

function saveSupporters($total_pages,$page,$Headers,$conn){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $supporters = $response['data']->data;
            for($row = 0; $row < count($supporters); $row++){ 
                $supporter_id = mysqli_real_escape_string($conn,$supporters[$row]->id);
                $first_name = mysqli_real_escape_string($conn,$supporters[$row]->first_name);
                $last_name = mysqli_real_escape_string($conn,$supporters[$row]->last_name);
                $email = mysqli_real_escape_string($conn,$supporters[$row]->email);
                $status = mysqli_real_escape_string($conn,$supporters[$row]->active);
            
                    $insertquery = "INSERT IGNORE INTO `supporters` (supporter_id,first_name,last_name,email,status) 
                    VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}";
            $response = RestCurl::get($URL, $Headers);
            $supporters = $response['data']->data;
            for($row = 0; $row < count($supporters); $row++){ 
                $supporter_id = mysqli_real_escape_string($conn,$supporters[$row]->id);
                $first_name = mysqli_real_escape_string($conn,$supporters[$row]->first_name);
                $last_name = mysqli_real_escape_string($conn,$supporters[$row]->last_name);
                $email = mysqli_real_escape_string($conn,$supporters[$row]->email);
                $status = mysqli_real_escape_string($conn,$supporters[$row]->active);
            
                    $insertquery = "INSERT IGNORE INTO `supporters` (supporter_id,first_name,last_name,email,status) 
                    VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}


function saveContributions($total_pages,$page,$Headers,$conn){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$i}";
            $response = RestCurl::get($URL, $Headers);
            $contributions = $response['data']->data;
            for($row = 0; $row < count($contributions); $row++){ 
                $email = $contributions[$row]->email;
                $email = $contributions[$row]->supporter->email;
                $email = mysqli_real_escape_string($conn,$email);
                $supporter_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id);
                $supporter_deprecated_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id_deprecated);
                $contribution_id = mysqli_real_escape_string($conn,$contributions[$row]->id);
                $contribution_number = mysqli_real_escape_string($conn,$contributions[$row]->contribution_number);
                $total_amount = mysqli_real_escape_string($conn,$contributions[$row]->total_amount);
                $is_paid = mysqli_real_escape_string($conn,$contributions[$row]->is_paid);
                $is_recurring = mysqli_real_escape_string($conn,$contributions[$row]->line_items[0]->is_recurring);
            
                    $insertquery = "INSERT IGNORE INTO contributions(email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring) 
                                        VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/contributions?page={$page}";
            $response = RestCurl::get($URL, $Headers);
            $contributions = $response['data']->data;
            for($row = 0; $row < count($contributions); $row++){ 
                $email = $contributions[$row]->email;
                $email = $contributions[$row]->supporter->email;
                $email = mysqli_real_escape_string($conn,$email);
                $supporter_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id);
                $supporter_deprecated_id = mysqli_real_escape_string($conn,$contributions[$row]->supporter->id_deprecated);
                $contribution_id = mysqli_real_escape_string($conn,$contributions[$row]->id);
                $contribution_number = mysqli_real_escape_string($conn,$contributions[$row]->contribution_number);
                $total_amount = mysqli_real_escape_string($conn,$contributions[$row]->total_amount);
                $is_paid = mysqli_real_escape_string($conn,$contributions[$row]->is_paid);
                $is_recurring = mysqli_real_escape_string($conn,$contributions[$row]->line_items[0]->is_recurring);
            
                    $insertquery = "INSERT IGNORE INTO contributions(email, supporter_id, supporter_deprecated_id, contribution_id, contribution_number, total_amount, is_paid, is_recurring) 
                                        VALUES( '$email',  '$supporter_id',  '$supporter_deprecated_id',  '$contribution_id', '$contribution_number', '$total_amount', '$is_paid', '$is_recurring'); ";
                    mysqli_multi_query($conn, $insertquery);
                    // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}

function saverecurringsupporters($total_pages,$page,$Headers,$conn,$profile){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $recurringsupporters = $response['data']->data;
            for($row = 0; $row < count($recurringsupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$recurringsupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$recurringsupporters[$row]->email);
                    $status = mysqli_real_escape_string($conn,$recurringsupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `recurringsupporters` (supporter_id,first_name,last_name,email,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $recurringsupporters = $response['data']->data;
            for($row = 0; $row < count($recurringsupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$recurringsupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$recurringsupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$recurringsupporters[$row]->email);
                    $status = mysqli_real_escape_string($conn,$recurringsupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `recurringsupporters` (supporter_id,first_name,last_name,email,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}


function cancelledSupporters($total_pages,$page,$Headers,$conn,$profile){
    if($total_pages > 1){
        for ($i = $page; $i <= $total_pages; $i++){
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$i}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $cancelledSupporters = $response['data']->data;
            for($row = 0; $row < count($cancelledSupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->email);
                    $status = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `cancelledSupporters` (supporter_id,first_name,last_name,email,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }
            }
        }
        else{
            $URL = "https://utcatholic.givecloud.co/admin/api/v2/supporters?page={$page}&&filter[recurringProfile]={$profile}";
            $response = RestCurl::get($URL, $Headers);
            $cancelledSupporters = $response['data']->data;
            for($row = 0; $row < count($cancelledSupporters); $row++){ 
                    $supporter_id = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->id);
                    $first_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->first_name);
                    $last_name = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->last_name);
                    $email = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->email);
                    $status = mysqli_real_escape_string($conn,$cancelledSupporters[$row]->active);

                        $insertquery = "INSERT IGNORE INTO `cancelledSupporters` (supporter_id,first_name,last_name,email,status) 
                        VALUES('$supporter_id','$first_name', '$last_name', '$email', '$status'); ";
                        mysqli_multi_query($conn, $insertquery);
                        print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
                        // print_r("Email: {$email} Inserted Successfully!"). PHP_EOL ;
               }

    }
}

function backupDatabaseAllTables($conn,$dbname ,$tables = '*'){

    if($tables == '*') { 
        $tables = array();
        $result = $conn->query("SHOW TABLES");
        while($supporters = $result->fetch_data()) { 
            $tables[] = $supporters[0];
        }
    } else { 
        $tables = is_array($tables)?$tables:explode(',',$tables);
    }

    $return = '';

    foreach($tables as $table){
        $result = $conn->query("SELECT * FROM $table");
        $numColumns = $result->field_count;

        /* $return .= "DROP TABLE $table;"; */
        $result2 = $conn->query("SHOW CREATE TABLE $table");
        $supporters2 = $result2->fetch_data();

        $return .= "\n\n".$supporters2[1].";\n\n";

        for($i = 0; $i < $numColumns; $i++) { 
            while($supporters = $result->fetch_data()) { 
                $return .= "INSERT IGNORE INTO $table VALUES(";
                for($j=0; $j < $numColumns; $j++) { 
                    $supporters[$j] = addslashes($supporters[$j]);
                    // $supporters[$j] = $supporters[$j];
                    if (isset($supporters[$j])) { 
                        $return .= '"'.$supporters[$j].'"' ;
                    } else { 
                        $return .= '""';
                    }
                    if ($j < ($numColumns-1)) {
                        $return.= ',';
                    }
                }
                $return .= ");\n";
            }
        }

        $return .= "\n\n\n";
    }

    // $handle = fopen('your_db_'.time().'.sql','w+');
    // fwrite($handle,$return);
    // fclose($handle);
    
    $file_name = "{$dbname}" . date('y-m-d') . '.sql';
    $file_handle = fopen($file_name, 'w+');
    fwrite($file_handle, $return);
    fclose($file_handle);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);
    echo "Database Export Successfully!";
}
