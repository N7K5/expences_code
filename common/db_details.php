
<?php

//@@@@@@@@@@@@@@@@@@@@@@@@
//@@@ Database Details @@@
//@@@@@@@@@@@@@@@@@@@@@@@@

    $db_name = 'x_expences'; //Name of the database
    $db_username = 'n7k5'; //Database Username
    $db_password = '00000000'; //Database Password
    $servername= "localhost"; //Host name










// ---------------------- Allowing CROSS ---------------------------------

function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
}

// call this to allow cors
// cors();


// ---------------------- Connecting to DB --------------------------------



$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$USER_ID= -1;
$CURRENT_THREAD_ID= 1;

if(isset($_GET["ssid"])) {
    $sql= 'SELECT userid FROM session WHERE session_key="'.$_GET["ssid"].'"';
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $USER_ID= $row["userid"];
        
        $sql= 'SELECT userid FROM session WHERE session_key="'.$_GET["ssid"].'"';
    }
    
    $sql= 'SELECT thread_id FROM expences WHERE userid="'.$USER_ID.'" ORDER BY id DESC';
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $CURRENT_THREAD_ID= $row["thread_id"];
    }
}




// $sql = "SELECT id, firstname, lastname FROM MyGuests";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }



?>