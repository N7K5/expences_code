<?php
include '../common/db_details.php';

if(!isset($USER_ID) || $USER_ID<0) {
    die('{"success":"false", "msg":"need a user to work with!"}');
}

$start_time= 0;
$end_time= time();
if(isset($_GET['start_time'])) {
    $start_time= intval($_GET['start_time']);
}
if(isset($_GET['end_time'])) {
    $end_time= intval($_GET['end_time']);
}

$sql= 'SELECT * FROM expences WHERE userid='.$USER_ID.' AND timestamp BETWEEN '.$start_time.' AND '. $end_time;

if(isset($_GET['thread'])) {
    if($_GET['thread']=="current") {
        $sql.=' AND thread_id='.$CURRENT_THREAD_ID;
    }
    else if($_GET['thread']=="last_two") {
        $sql.=' AND thread_id BETWEEN '.$CURRENT_THREAD_ID-1 .' AND '.$CURRENT_THREAD_ID;
    }
    else if($_GET['thread']=="last_three") {
        $sql.=' AND thread_id BETWEEN '.$CURRENT_THREAD_ID-2 .' AND '.$CURRENT_THREAD_ID;
    }
    else if($_GET['thread']=="last") {
        $sql.=' AND thread_id='.$CURRENT_THREAD_ID-1;
    }
    else if($_GET['thread']=="2nd_last") {
        $sql.=' AND thread_id='.$CURRENT_THREAD_ID-2;
    }
}


if(isset($_GET['spend_amnt'])) {
    if($_GET['spend_amnt'] == 'posetive') {
        $sql.=' AND cost > 0';
    }
    else if($_GET['spend_amnt'] == 'negative') {
        $sql.=' AND cost < 0';
    }
}

if(isset($_GET['expence_type'])) {
    if($_GET['expence_type'] == 1) {
        $sql.=' AND expence_type = 1';
    }
    if($_GET['expence_type'] == 2) {
        $sql.=' AND expence_type = 2';
    }
    if($_GET['expence_type'] == 3) {
        $sql.=' AND expence_type = 3';
    }
    if($_GET['expence_type'] == 4) {
        $sql.=' AND expence_type = 4';
    }
    if($_GET['expence_type'] == 5) {
        $sql.=' AND expence_type = 5';
    }
    if($_GET['expence_type'] == 6) {
        $sql.=' AND expence_type = 6';
    }
    if($_GET['expence_type'] == 7) {
        $sql.=' AND expence_type = 7';
    }
    if($_GET['expence_type'] == 8) {
        $sql.=' AND expence_type = 8';
    }
}

$sql.=' ORDER BY timestamp';

if(isset($_GET['limit'])) {
    $sql.= ' LIMIT '.intval($_GET['limit']);
}

// echo $sql;

try {
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $res= '{"success":"true", "msg":"Fetched '.$result->num_rows.' rows!", "data":[';
        while($row= $result->fetch_assoc()) {
            $data= '{';
            $data.= ' "timestamp":'.$row['timestamp'].', ';
            $data.= ' "cost":'.$row['cost'].', ';
            $data.= ' "thread_id":'.$row['thread_id'].', ';
            $data.= ' "expence_type":'.$row['expence_type'].', ';
            // item needs to be sanatized
            $item= $row['item'];
            $item= filter_var($item, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $item= str_replace('"', '', $item);
            $item= str_replace('\'', '', $item);
            $item= str_replace('\\', '', $item);
            $item= str_replace('\n', '', $item);
            $data.= ' "item":"'.$item.'" ';
            $data.='}';

            $res.=$data.',';
        }
        $res=substr($res, 0, -1).']}';
        echo $res;
        exit();
    }
    else {
        die('{"success":"true", "msg":"Fetched 0 rows!", "data":"[]"}');
    }
} catch(Exception $e) {
    die('{"success":"false", "msg":"Error in server!"}');
}


?>