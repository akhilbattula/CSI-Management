<?php

   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'inventorymanagement');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   date_default_timezone_set('Asia/Kolkata');
   if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }
//else{
//    echo 'Connection Successful';
//}
