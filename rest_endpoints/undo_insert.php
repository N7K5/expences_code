<?php
include '../common/db_details.php';

if(!isset($USER_ID) || $USER_ID<0) {
    die('{"success":"false", "msg":"need a user to work with!"}');
}

$sql= 'DELETE FROM expences WHERE id= (SELECT id FROM expences WHERE userid='.$USER_ID.' ORDER BY id DESC LIMIT 1)';

try {
    $result = $conn->query($sql);
    if($result == TRUE) {
        echo '{"success":"true", "msg":"Deleted last row"}';
        exit;
    } else {
        die('{"success":"false", "msg":"unable to delete"}');
    }
} catch(Exception $e) {
    die('{"success":"false", "msg":"Failed to execute"}');
}


?>