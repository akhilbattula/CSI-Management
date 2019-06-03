<?php
session_start();
include './php/config.php';
$login_id = $_SESSION['login_id'];
echo $login_id;
$date = date('Y-m-d H:i:s');

$sql_log = "UPDATE `log_register` SET `logout_at`='$date' WHERE `ts_id`=$login_id";
    if ($db->query($sql_log) === TRUE) {
        session_unset(); 
        session_destroy();
        header("Location: ./index.php");
        $log_status="Login time logged.";
    }else{
        echo mysqli_error($db);
        session_unset(); 
        session_destroy();
        header("Location: ./index.php");        
        $log_status="Failed to log data.";
    }
