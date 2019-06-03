<?php
session_start();
include '../php/config.php';

if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}
    
$prod_id = intval($_GET['q']);

    $query_product = "SELECT `prod_name`, `prod_price`, `gst`, `imei_nos`,`model_no` FROM `product` WHERE `prod_id`=$prod_id;";
    $result_product = mysqli_query($db, $query_product);
    if (!$result_product) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $count_product = mysqli_num_rows($result_product);
    $row_product = mysqli_fetch_array($result_product);

echo json_encode($row_product);
