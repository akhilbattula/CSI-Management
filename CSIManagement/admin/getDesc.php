<?php
session_start();
include '../php/config.php';

if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}
    
$table_name = $_GET['q'];

    $query_desc = "desc `$table_name`";
    $result_desc = mysqli_query($db, $query_desc);
    if (!$result_desc) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $json = array();
    $count_desc = mysqli_num_rows($result_desc);
    while($row_desc = mysqli_fetch_array($result_desc))
    {
        $json[] = $row_desc;
    }

echo json_encode($json);
