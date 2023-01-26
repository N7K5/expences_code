<?php
include '../common/db_details.php';

if(!isset($USER_ID) || $USER_ID<0) {
    die('{"success":"false", "msg":"need a user to work with!"}');
}

$sql = 'DELETE FROM session WHERE session_key='.$_GET["ssid"];
if(isset($_GET['all'])) {
    $sql = 'DELETE FROM session WHERE userid='.$USER_ID;
}

try {
    if($conn->query($sql)==TRUE) {
       echo '{"success":"true", "msg":"Logged out!"}';
       exit();
    }
    else {
        die('{"success":"false", "msg":"Not in session!"}');
    }

} catch(Exception $e) {
    die('{"success":"false", "msg":"Error at server! '. $e.'"}');
}

?>