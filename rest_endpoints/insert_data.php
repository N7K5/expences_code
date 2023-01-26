<?php
include '../common/db_details.php';

if(!isset($USER_ID) || $USER_ID<0) {
    die('{"success":"false", "msg":"need a user to work with!"}');
}
date_default_timezone_set('Asia/Calcutta');
$now = time();

// timestamp field is optional. By default current time is set.
if(isset($_GET['timestamp'])) {
    $now= $_GET['timestamp'];
}



if(!isset($_GET['item']) || !isset($_GET['cost']) || !isset($_GET['expence_type']) ) {
    die('{"success":"false", "msg":"Invalid data!"}');
}

if(isset($_GET['new_thread'])) {
    $CURRENT_THREAD_ID+=1;
}

try {
    $sql= 'INSERT INTO expences(userid, timestamp, item, cost, expence_type, thread_id) VALUES
         ("'.$USER_ID.'", "'.$now.'", "'.$_GET['item'].'", "'.$_GET['cost'].'", "'.$_GET['expence_type'].'", "'.$CURRENT_THREAD_ID.'")';
    if($conn->query($sql) == TRUE) {
        echo('{"success":"true", "msg":"Done!"}');
        exit();
    }
    else {
        die('{"success":"false", "msg":"Ubable to add data!"}');
    }
} catch(Exception $e) {
    die('{"success":"false", "msg":"Ubable to add, Server error!"}'.$e);
}

?>