<?php

    include '../common/db_details.php';

    if(!isset($_GET['user']) || !isset($_GET['pass'])) {
        die('{"success":"false", "msg":"Not enough params!"}');
    }


    try {
        $sql= 'SELECT id, other_details_json FROM users WHERE user="'.$_GET['user'].'" and pass="'.$_GET['pass'].'"';
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id= $row['id'];
            $other_details= $row['other_details_json'];
        }
        else {
            die('{"success":"false", "msg":"Invalid User!"}');
        }


        $session_key= rand(10000000, 99999999);


        $sql= 'INSERT INTO session(userid, session_key) VALUES("'.$user_id.'", "'.$session_key.'")';
        if($conn->query($sql)== TRUE) {
            echo '{"success":"true", "msg":"loggin success", "key":"'.$session_key.'", "other_details": "'.$other_details.'"}';
            exit();
        } else {
            die('{"success":"false", "msg":"Unable to create session!"}');
        }

    } catch(Exception $e) {
        die('{"success":"false", "msg":"Error at server! '. $e.'"}');
    }

?>