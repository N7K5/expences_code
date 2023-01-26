<?php
    include "../common/db_details.php";
    
    $sql= "
    CREATE TABLE users (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user TEXT NOT NULL UNIQUE,
        pass TEXT NOT NULL,
        other_details_json TEXT
    )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";

    try {
        $conn->query($sql);
        echo '<p class="success">Created users database Successfully...</p>';
    } catch(Exception $e) {
        echo '<p class="error">Unable to create users database...</p>';
    }



    $sql= "
    CREATE TABLE expences (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        userid INT NOT NULL,
        timestamp INT NOT NULL UNIQUE KEY,
        item TEXT NOT NULL,
        cost INT NOT NULL,
        expence_type INT NOT NULL,
        thread_id INT NOT NULL,
        FOREIGN KEY (userid) REFERENCES users(id)
    )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB
    ";

    try {
        $conn->query($sql);
        echo '<p class="success">Created expences database Successfully...</p>';
    } catch(Exception $e) {
        echo '<p class="error">Unable to create expences database...</p>';
    }



    $sql= "
    CREATE TABLE session (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        userid INT NOT NULL,
        session_key INT NOT NULL UNIQUE KEY,
        FOREIGN KEY (userid) REFERENCES users(id)
    )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB
    ";

    try {
        $conn->query($sql);
        echo '<p class="success">Created session database Successfully...</p>';
    } catch(Exception $e) {
        echo '<p class="error">Unable to create session database...</p>';
    }
    

?>