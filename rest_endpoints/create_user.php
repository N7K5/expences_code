
<?php

    include '../common/db_details.php';

    if(!isset($_GET['user']) || !isset($_GET['pass'])) {
        die('{"success":"false", "msg":"Not enough params!"}');
    }

    if(strlen($_GET['user'])<4) {
        die('{"success":"false", "msg":"invalid username!"}');
    }

    if(strlen($_GET['pass'])<8) {
        die('{"success":"false", "msg":"invalid username!"}');
    }


    $extra_json= "";
    if(isset($_POST['extra_json'])) {
        $extra_json= $_POST['extra_json'];
    }

    $sql= 'INSERT INTO users(user, pass, other_details_json) VALUES ("'.$_GET['user'].'", "'.$_GET['pass'].'", "'.$extra_json.'")';

    try {
        if($conn->query($sql) == TRUE) {
            echo '{"success":"true", "msg":"created USER"}';
        } else {
            die('{"success":"false", "msg":"Unable to add user"}');
        }
    } catch(Exception $e) {
        die('{"success":"false", "msg":"Unable to add user"}');
    }
    


?>