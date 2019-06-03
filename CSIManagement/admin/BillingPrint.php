<?php
session_start();
include '../php/config.php';

$id = $_GET['id'];
$status="";
$status="";
$error = "";
$sql = "";
$error_product = "";
if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}
    $sql_invoice = "SELECT `invoice_id`, `cust_id`, `no_of_products`, `total_amount`, `invoice_status`, `mode_of_payment`, `emi_vendor`, `no_of_months`, `emi_amount`, `bill_no`, `comments`, `store_id`, `invoice_date`, `created_at`, `created_by`, `last_edited_by`, `last_modified_at` FROM `invoice` WHERE `invoice_id`='$id'";
    $result_invoice = mysqli_query($db, $sql_invoice);
    if (!$result_invoice) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_invoice  = mysqli_num_rows($result_invoice );
    $row_invoice  = mysqli_fetch_array($result_invoice );
    $cust_id = $row_invoice[1];    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <title>CSI Management</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="../css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="../css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="../css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="../css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="../css/helper.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
@import "https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700";strong{font-weight:700}
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}
#container{height:1122.519685px;position:relative;padding:4%}#header{height:80px}#header > #reference{float:right;text-align:right}#header > #reference h3{margin:0}#header > #reference h4{margin:0;font-size:85%;font-weight:600}#header > #reference p{margin:0;margin-top:2%;font-size:85%}#header > #logo{width:50%;float:left}#fromto{height:160px}#fromto > #from,#fromto > #to{width:45%;min-height:90px;margin-top:30px;font-size:85%;padding:1.5%;line-height:120%}#fromto > #from{float:left;width:45%;background:#efefef;margin-top:30px;font-size:85%;padding:1.5%}#fromto > #to{float:right;border:solid grey 1px}#items{margin-top:20px}#items > p{font-weight:700;text-align:right;margin-bottom:1%;font-size:65%}#items > table{width:100%;font-size:85%;border:solid grey 1px}#items > table th:first-child{text-align:left}#items > table th{font-weight:400;padding:1px 4px}#items > table td{padding:1px 4px}#items > table th:nth-child(2),#items > table th:nth-child(4){width:50px}#items > table th:nth-child(6){width:100px}#items > table th:nth-child(3){width:60px}#items > table th:nth-child(5){width:80px}#items > table tr td:not(:first-child){text-align:right;padding-right:1%}#items table td{border-right:solid grey 1px}#items table tr td{padding-top:3px;padding-bottom:3px;height:10px}#items table tr:nth-child(1){border:solid grey 1px}#items table tr th{border-right:solid grey 1px;padding:3px}#items table tr:nth-child(2) > td{padding-top:8px}#summary{height:170px;margin-top:30px}#summary #note{float:left}#summary #note h4{font-size:10px;font-weight:600;font-style:italic;margin-bottom:4px}#summary #note p{font-size:10px;font-style:italic}#summary #total table{font-size:85%;width:260px;float:right}#summary #total table td{padding:3px 4px}#summary #total table tr td:last-child{text-align:right}#summary #total table tr:nth-child(3){background:#efefef;font-weight:600}#footer{margin:auto;position:absolute;left:4%;bottom:4%;right:4%;border-top:solid grey 1px}#footer p{margin-top:1%;font-size:65%;line-height:140%;text-align:center}
</style>
</head>

<body class="fix-header fix-sidebar" onload="window.print()">
    <!-- Preloader - style you can find in spinners.css -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                        <div class="card card-outline-primary">
                            <div class="card-body">
                                  <div id="container">
                                    <div id="header">
                                            <div id="logo">
                                                <img src="http://placehold.it/230x70&text=logo" alt="">
                                            </div>
                                            <div id="reference">
                                                <h3><strong>Invoice : <?php echo $row_invoice[0]?></strong></h3>
                                                <h4>Invoice Date : <?php echo $row_invoice[12]?></h4>
                                                <!--<p>Invoice Date : </p>-->
                                            </div>
                                    </div>
                                    <div id="fromto">
                                            <div id="from">
<?php
        $query_stores = "SELECT `store_id`, `store_name`, `store_address`, `store_type` FROM `stores` WHERE `store_id`=$row_invoice[11]";
        $result_stores = mysqli_query($db, $query_stores);
            if (!$result_stores) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           
                
            }
            $count_stores = mysqli_num_rows($result_stores);
            $row_stores = mysqli_fetch_array($result_stores);
            
            ?>                                                                                                              
                                        <p>
                                            <strong>Mobihub</strong><br>
                                            <?php echo $row_stores[1];?><br>
                                            <?php echo $row_stores[2];?><br>
                                        </p>
                                    </div>
<?php
        $query_customer = "SELECT `cust_id`, `cust_first_name`, `cust_last_name`, `cust_gender`, `cust_dob`, `cust_address`, `cust_city`, `cust_state`, `cust_country`, `cust_postcode`, `cust_aadhar`, `cust_mobileno1`, `cust_mobileno2`, `cust_panno`, `cust_purchasecount`, `cust_email`, `cust_comments`, `created_by`, `date_created`, `edited_by`, `last_edited` FROM `customer` WHERE `cust_id`=$cust_id";
        $result_customer = mysqli_query($db, $query_customer);
            if (!$result_customer) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count_customer = mysqli_num_rows($result_customer);
            $row_customer = mysqli_fetch_array($result_customer);
            $name = $row_customer[1].' '.$row_customer[2];
            $address = $row_customer[5].", ".nl2br($row_customer[6]).", ".nl2br($row_customer[7]).", ".nl2br($row_customer[8])." - ".nl2br($row_customer[9]);
            
?>
                                            <div id="to">
                                                <p>
                                                    <strong><?php echo $name?></strong><br>
                                                    <?php echo $row_customer[5]?>,<br>
                                                    <?php echo $row_customer[6]?>,<br>
                                                    <?php echo $row_customer[7]?>,<br>
                                                    <?php echo $row_customer[8]?> - <?php echo $row_customer[9]?><br>
                                                    Ph. No: <?php echo $row_customer[11]?>, <?php echo $row_customer[12]?><br>
                                                    Email: <?php echo $row_customer[15]?><br>

                                                </p>
                                            </div>
                                    </div>
                                      <br>
                                      <div id="items">
                                            <!--<p>Montants exprimés en Euros</p>-->
                                            <table>
                                                    <tr>
                                                            <th>Product Name</th>
                                                            <th>Price</th>
                                                            <th>GST</th>
                                                            <th>Quantity</th>
                                                            <th>Discount</th>
                                                            <th>Total Price</th>
                                                    </tr>
<?php
    $query_products = "SELECT `id`, `product_id`, `quantity`, `invoice_id`, `discount`, `total_cost` FROM `invoice_products` WHERE `invoice_id`='$row_invoice[0]';";
    $result_products = mysqli_query($db, $query_products);
    if (!$result_products) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_products = mysqli_num_rows($result_products);
            if($count_products === 0){
                    $error = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result_products))
                {
                    $query_products_details = "SELECT `prod_id`, `prod_name`, `prod_price`, `gst`, `require_auth`, `imei_nos`, `model_no` FROM `product` WHERE `prod_id`=$row2[1];";
                    $result_products_details = mysqli_query($db, $query_products_details);
                    if (!$result_products_details) {
                        printf("Error: %s\n", mysqli_error($db));
                        exit();
                    }
                    $count_products_details = mysqli_num_rows($result_products_details);
                    $row_products_details = mysqli_fetch_array($result_products_details);
                    $product_name = $row_products_details[1].''.$row_products_details[6];
                    $gst = ($row_products_details[2]/100)*$row_products_details[3];
                    echo "<tr><td>$product_name</td><td>$row_products_details[2]</td><td>$gst<br>($row_products_details[3]%)</td><td>$row2[2]</td><td>$row2[4]</td><td>$row2[5]</td></tr>";
                }
    }
?>
                        <tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
	
                                            </table>
                                    </div>
                                    <div id="summary">
                                            <div id="note">
                                                    <h4>Mode of Billing :<?php echo $row_invoice[5]?></h4>
                                                    <p></p>
                                            </div>
                                            <div id="total">
                                                    <table border="1">
                                                            <tr>
                                                                    <td>Total Amount</td>
                                                                    <td><?php echo $row_invoice[3];?></td>
                                                            </tr>
                                                    </table>
                                            </div>
                                    </div>

                                    <div id="footer">
                                            <p></p>
                                    </div>
                            </div>
                            
                            </div>
                        </div>

                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
<?php 
$query = "SELECT count(`invoice_id`) FROM `invoice`";
$result = mysqli_query($db, $query);
if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
}
$count = mysqli_num_rows($result);
    if($count != 0){
            $row2 = mysqli_fetch_array($result);
            $id_inv = $row2[0]+1;
    }
?>    
    <script src="../js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->


    <!-- Amchart -->
    <script src="../js/lib/morris-chart/raphael-min.js"></script>
    <script src="../js/lib/morris-chart/morris.js"></script>
    <script src="../js/lib/morris-chart/dashboard1-init.js"></script>

    
    <script src="../js/lib/calendar-2/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="../js/lib/calendar-2/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="../js/lib/calendar-2/prism.min.js"></script>
    <!-- scripit init-->
    <script src="../js/lib/calendar-2/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="../js/lib/calendar-2/pignose.init.js"></script>

    <script src="../js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="../js/lib/owl-carousel/owl.carousel-init.js"></script>

    <!-- scripit init-->

    <script src="../js/lib/datatables/datatables.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="../js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="../js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="../js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="../js/lib/datatables/datatables-init.js"></script>

    <script src="../js/billing_js.js"></script>
    <script src="../js/scripts.js"></script>

</body>

</html>
