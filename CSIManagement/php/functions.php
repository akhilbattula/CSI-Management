<?php
include './config.php';

function get_customers(){
    $datarow = "";
        $query = "SELECT `cust_id`, `cust_name`, `cust_address`, `cust_city`, `cust_state`, `cust_mobileno1`, `cust_aadhar`, `cust_purchasecount` FROM customer order by 'date_created' desc;";
        $result = mysqli_query($db, $query);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count = mysqli_num_rows($result);
            if($count === 0){
                $datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result))
                {
                    $address = $row2[2].", ".nl2br($row2[3]).", ".nl2br($row2[4]);
                    $datarow = $datarow."<tr><td><a style=\"text-decoration: underline;\" href=\"#\">$row2[0]</a></td><td>$row2[1]</td><td>$address</td><td>$row2[5]</td><td>$row2[6]</td><td>$row2[7]</td><td><div class=\"dropdown\">
            <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Action
            <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\">View</a></li><li><a href=\"../EditCustomer.php?valueID=$row2[0]\">Edit</a></li>
              <li><a onClick=\"javascript: return confirm('Do you want to delete record?');\" href=\"./php/Delete.php?del_id=$row2[0]&del_type=customer\">Delete</a></li></ul></div></td></tr>";
        }
        }
        return $datarow;    
}

function get_products(){
$datarow = "";
$query = "SELECT `prod_id`, `prod_name`, `prod_category`, `prod_price`, `gst`, `imei_count`, `no_in_stock`, `from_shipment_id` FROM product order by `date_created` DESC;";
$result = mysqli_query($db, $query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count = mysqli_num_rows($result);
            if($count === 0){
             $datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result))
                {
             $datarow = $datarow."<tr><td>$row2[0]</td><td>$row2[1]</td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[4]</td><td>$row2[5]</td><td>$row2[6]</td><td>
    <div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Action
    <span class=\"caret\"></span></button>
    <ul class=\"dropdown-menu\"><li><a href=\"../EditProduct.php?valueID=$row2[0]\">Edit</a></li>
    <li><a onClick=\"javascript: return confirm('Do you want to delete record?');\" href=\"../Delete.php?del_id=$row2[0]&del_type=product\">Delete</a></li>
    </ul></div></td></tr>"; 
      }
    }
    echo $datarow;    
}

function get_shipments(){
$query = "SELECT `shipment_id`, `company_name`, `no_of_products`, `total_price`, `gst_paid`, IFNULL(`comments`,'---'), `shipment_date` FROM `shipment` order by 'shpment_id' asc;";
$result = mysqli_query($db, $query);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count = mysqli_num_rows($result);
            if($count === 0){
                $datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
    }else{
        while($row2 = mysqli_fetch_array($result))
        {
            $query_count_prod = "SELECT count(`prod_id`) FROM `shipment_products` where `shipment_id` like '$row2[0]'";
            $result_count_prod = mysqli_query($db, $query_count_prod);
            if (!$result_count_prod) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }
            $row_count_prod = mysqli_fetch_array($result_count_prod);
            $count_of_products = $row_count_prod[0];
            
            $datarow = $datarow."<tr><td><a style=\"text-decoration: underline;\" href=\"../ShipmentsDetails.php?id=$row2[0]\">$row2[0]</a></td><td>$row2[1]</td><td>$count_of_products</td><td>$row2[3]</td><td>$row2[4]</td><td>$row2[5]</td><td>$row2[6]</td><td>
                <div class=\"dropdown\">
                <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Action
                <span class=\"caret\"></span></button>
                <ul class=\"dropdown-menu\">
                  <li><a href=\"../ShipmentsDetails.php?id=$row2[0]\">View</a></li>
                  <li><a href=\"../EditShipmentsDetails.php?id=$row2[0]\">Edit</a></li>
                  <li><a onClick=\"javascript: return confirm('Do you want to delete record?');\" href=\"../Delete.php?del_id=$row2[0]&del_type=customer\">Delete</a></li>
                </ul>
                </div>
                </td>
                </tr>";
        }
    }
    echo $datarow;    
}

function get_shipment_products($row_id){
    $id = $row_id;
    $query_shipment = "SELECT `shipment_id`, `company_name`, `no_of_products`, `total_price`, `gst_paid`, IFNULL(`comments`,'---'), `shipment_date` FROM `shipment` where shipment_id='$id';";
    $result_shipment = mysqli_query($db, $query_shipment);
    if (!$result_shipment) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_shipment = mysqli_num_rows($result_shipment);
    $row_shipment = mysqli_fetch_array($result_shipment);
    $query_count_prod = "SELECT count(`prod_id`) FROM `shipment_products` where `shipment_id` like '$row_shipment[0]'";
    $result_count_prod = mysqli_query($db, $query_count_prod);
    if (!$result_count_prod) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $row_count_prod = mysqli_fetch_array($result_count_prod);
    $count_of_products = $row_count_prod[0];

    $query = "SELECT `prod_id`, `prod_name`, `prod_category`, `prod_price`, `gst_percentage`, `imei_count`, `quantity`, `date_created` FROM shipment_products where prod_id='$id' order by `date_created` DESC;";
    $result = mysqli_query($db, $query);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }
        $count = mysqli_num_rows($result);
        if($count === 0){
                $datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
          }else{
            while($row2 = mysqli_fetch_array($result))
            {
                $datarow = $datarow."<tr><td>$row2[0]</td><td>$row2[1]</td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[4]</td><td>$row2[5]</td><td>$row2[6]</td></tr>";
            }
        }
    echo $datarow;    
}

function products_session($array,$index){

    
    $_SESSION['products_array'][$index] = explode(",",$array);
//    $status .= $array;
}
