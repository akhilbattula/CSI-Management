<?php
session_start();
include '../php/config.php';

$prod_name = "";
$price = 0;
$gst = 0;
$imeis = "";
$status="";
$error = "";
$sql = "";
$error_product = "";
if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}

if(isset($_POST['proceed'])){

    $invoice_no = mysqli_real_escape_string($db,$_POST['invoice_no']);
    $invoice_date = mysqli_real_escape_string($db,$_POST['invoice_date']);
    $invoice_status = "Processed";
    
    $cust_id = mysqli_real_escape_string($db,$_POST['cust_id']);

    $mode_of_billing = mysqli_real_escape_string($db,$_POST['modeofpayment']);
    $bill_no = mysqli_real_escape_string($db,$_POST['bill_no']);
    $store_id = mysqli_real_escape_string($db,$_POST['store_id']);
    $emi_vendor = mysqli_real_escape_string($db,$_POST['emi_vendor']);
    $no_of_months = mysqli_real_escape_string($db,$_POST['emi_months']);
    $emi_amount = mysqli_real_escape_string($db,$_POST['emi_amount']);
    $comments = mysqli_real_escape_string($db,$_POST['billing_comments']);
    $total_amount = mysqli_real_escape_string($db,$_POST['total_amount_input']);
    $no_of_products = mysqli_real_escape_string($db,$_POST['no_of_products']);
    $created_by = $_SESSION['login_user'];
    $date = date('Y-m-d H:i:s');

    if(strcmp($mode_of_billing,'EMI')===0){
        $sql = "INSERT INTO `invoice`(`invoice_id`, `cust_id`, `no_of_products`,`invoice_status`, `total_amount`,`mode_of_payment`, `emi_vendor`, `no_of_months`, `emi_amount`, `bill_no`, `comments`, `store_id`, `invoice_date`, `created_at`, `created_by`) VALUES ('$invoice_no','$cust_id',$no_of_products,'$invoice_status',$total_amount,'$mode_of_billing','$emi_vendor',$no_of_months,$emi_amount,'$bill_no','$comments','$store_id','$invoice_date','$date','$created_by')";
        
    }else{
        $sql = "INSERT INTO `invoice`(`invoice_id`, `cust_id`, `no_of_products`,`invoice_status`, `total_amount`,`mode_of_payment`, `bill_no`, `comments`, `store_id`, `invoice_date`, `created_at`, `created_by`) VALUES ('$invoice_no','$cust_id',$no_of_products,'$invoice_status',$total_amount,'$mode_of_billing','$bill_no','$comments','$store_id','$invoice_date','$date','$created_by')";
    
    }

    if ($db->query($sql) === TRUE) {
      
        $prod_ids = $_POST['id'];
        $quantity = $_POST['quantity'];    
        $discount = $_POST['discount'];    
        $total = $_POST['total'];
        $sql_products = "INSERT INTO `invoice_products`(`invoice_id`,`product_id`, `quantity`, `discount`, `total_cost`) VALUES ";
        foreach($prod_ids as $x => $n) {
            $error = $error.", ".$prod_ids[$x].$invoice_no.$discount[$x];
            $sql_products = $sql_products ."('$invoice_no',$prod_ids[$x],$quantity[$x],$discount[$x],$total[$x]),";
        }
        $sql_products = substr($sql_products,0,strlen($sql_products)-1);
        echo $sql_products;
        if ($db->multi_query($sql_products) === TRUE) {
            header('Location: ../index.php');
            $status = "<div class=\"alert alert-success\">
            <strong>Sucess!</strong> Billing done successfully.
            </div>";
        }else{
            $status = "<div class=\"alert alert-danger\">
            <strong>Error!</strong> Some Error occurred while adding invoice. Please contact support team.
            </div>";
            //$error =  "Error: " . $sql_products . "<br>" . $db->error;
        }
    } else {
        $status = "<div class=\"alert alert-danger\">
                    <strong>Error!</strong> Some Error occurred while adding invoice. Please contact support team.
                    </div>";
        //$error =  "Error: " . $sql . "<br>" . $db->error;
    }
                
}
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
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
	<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="Dashboard.php">
                        <!-- Logo icon -->
                        <!-- <b><img src="images/logo.png" alt="homepage" class="dark-logo" /></b>-->
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <!--<span><img src="images/logo-text.png" alt="homepage" class="dark-logo" /></span>-->
                        <span><h2>CSI Management</h2></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- Messages -->
                        <!-- End Messages -->
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../images/users/5.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                                    <li><a href="#"><i class="ti-settings"></i> Mail</a></li>
                                    <li><a href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li><a  href="Dashboard.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard </span></a></li>
                        <li class="nav-label">Apps</li>
                        <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Customers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="AddCustomer.php">Add Customer</a></li>
                                <li><a href="ViewCustomers.php">View Customers</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-clipboard"/></i> <span class="hide-menu">Products</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="AddProduct.php">Add Product</a></li>
                                <li><a href="ViewProducts.php">View Products</a></li>
                            </ul>
                        </li>
                         <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive"></i><span class="hide-menu">Shipments</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="AddShipment.php">Add Shipment</a></li>
                                <li><a href="ViewShipments.php">View Shipments</a></li>
                            </ul>
                        </li>
                        <li> <a  href="BillingPage.php" aria-expanded="false"><i class="fa fa-desktop"/></i><span class="hide-menu">Billing </span></a></li>
                        <li class="nav-label">Statistics</li>
                        <li> <a href="Reports.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Reports </span></a></li>          
                        
                        <li class="nav-label">Stock & Resources</li>
                        <li> <a href="CustomerNeeds.php" aria-expanded="false"><i class="fa fa-sticky-note"></i><span class="hide-menu">Customer Needs </span></a></li>          
                        <li> <a href="RequiredStock.php" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Stock Required </span></a></li>          
                        <li> <a href="StaffManagement.php" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">Staff Management </span></a></li>          
                        <li> <a href="UsersManagement.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Users Management </span></a></li>          
                        
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Billing Page</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Billing</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                        <div class="card card-outline-primary">
                            
                            <div class="card-body">
                                <form id="billing_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                                    <div class="form-body">
                                        <h3 class="card-title m-t-15">Invoice Details</h3>
                                        <?php echo $status ?>
                                        <?php echo $error ?>
                                        
                                        <hr>
                                        <small style="color: red" class="form-control-feedback">* fields are mandatory</small>
                                        <div class="row p-t-20">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Invoice No *</label>
                                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Invoice Date *</label>
                                                    <input autocomplete="off" type="date" name="invoice_date" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="card-title m-t-15">Customer Info</h3>
                                        <hr>
                                        <h6 class="form-control-feedback" ><a id="search_customer" style="color: #0000EE" href="javascript:void(0)" >Select existing customer</a> or <a style="color: #0000EE" href="AddCustomer.php" target="_blank">Add a New customer</a></h6>
                                        <div id="customer_popup" style="display: none;margin-bottom: 15px">
                                            <?php
                                                    $datarow_customer = "";
                                                    $query_customer = "SELECT `cust_id`, `cust_first_name`, `cust_last_name`, `cust_gender`, `cust_dob`, `cust_address`, `cust_city`, `cust_state`, `cust_country`, `cust_postcode`, `cust_aadhar`, `cust_mobileno1`, `cust_mobileno2`, `cust_panno`, `cust_purchasecount`, `cust_comments`, `date_created`, `last_edited` FROM `customer` ORDER BY `cust_id` DESC";
                                                    $result_customer = mysqli_query($db, $query_customer);
                                                        if (!$result_customer) {
                                                            printf("Error: %s\n", mysqli_error($db));
                                                            exit();           }
                                                        $count_customer = mysqli_num_rows($result_customer);
                                                        if($count_customer === 0){
                                                            //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
                                                          }else{
                                                            while($row2 = mysqli_fetch_array($result_customer))
                                                            {
                                                                $cust_name = strtoupper($row2[1]." ".$row2[2]);
                                                                $mobilenos = $row2[11].", ".$row2[12];
                                                                $address = $row2[5].", ".nl2br($row2[6]).", ".nl2br($row2[7]).", ".nl2br($row2[8])." - ".nl2br($row2[9]);
                                                                $datarow_customer = $datarow_customer."<tr><td><a style=\"text-decoration: underline;\" href=\"#\">$row2[0]</a></td><td>$cust_name</td><td>$address</td><td>$mobilenos</td><td>$row2[10]</td><td>$row2[14]</td><td><div class=\"dropdown\">
                                                                <button class=\"btn btn-primary\" name=\"btnselect_customer\"  type=\"button\" data-toggle=\"dropdown\">Select </button></td></tr>";
                                                    }
                                                    }
                                            ?>
                                            <table name="myTable" id="myTable" style="margin-bottom: 25px;margin-top: 15px;" class="display nowrap table table-hover table-striped table-bordered" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Customer ID</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Mobile No</th>
                                                        <th>Aadhar No</th>
                                                        <th>Purchase Count</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo $datarow_customer;?>                                          
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row p-t-20">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Customer ID *</label>
                                                    <input type="text" id="cust_id" class="form-control" name="cust_id" readonly required> 
                                                </div>
                                            </div>    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Full Name *</label>
                                                    <input type="text" id="fullname" class="form-control" name="fullname" readonly required>
                                                </div>
                                            </div>    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Address *</label>
                                                    <input type="text" id="address" class="form-control" name="address" readonly>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mobile Nos</label>
                                                    <input type="text" id="mobile_nos" class="form-control" name="mobile_nos" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Aadhar Number </label>
                                                    <input type="number" class="form-control" name="aadharno" id="aadharno" readonly>
                                                </div>
                                            </div>
                                            <!--span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Purchase Count</label>
                                                    <input type="text" class="form-control" id="purchase_count" style="text-transform: uppercase" name="purchase_count" readonly>
                                                </div>
                                            </div>                                            
                                        </div>                                        
                                        <h3 class="card-title m-t-15">Products</h3>
                                        <hr>
                                        <small style="color: red" class="form-control-feedback">* fields are mandatory</small>
                                        <div class="row">
                                        <div style="padding: 15px"> 
                                        <h5 class="form-control-feedback" style="color: red"><?php echo $error_product ?></h5>
                                        <div class="row p-t-20">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Product ID *</label>
                                                    <div >
                                                    <div style="width: 85%;float: left">
                                                        <input type="text" class="form-control" name="id">
                                                    </div>
                                                    <div style="width: 15%; text-align: center ;padding-left: 5px; float: right">
                                                        <button type="button" name="search_product" id="search_product" class="btn btn-success"><i class="fa fa-search"></i> </button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Product Name *</label>
                                                    <input type="text" class="form-control" name="name" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Price *</label>
                                                    <input type="number" name="price" class="form-control" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>GST </label>
                                                    <input type="number" name="gst" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Model No </label>
                                                    <input type="text" name="model_no" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>IMEI Nos </label>
                                                    <input type="text" name="imei_nos" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Quantity *</label>
                                                    <input type="number" name="quantity" class="form-control">
                                                </div>
                                            </div>   
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Discount </label>
                                                    <input type="number" value=0 name="discount" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                       <table class="table table-bordered table-hover" id="myTable">  
                                                <thead>  
                                                    <th>Product ID</th>  
                                                    <th>Product Name</th>  
                                                    <th>Price</th>  
                                                    <th>GST</th>                                                      
                                                    <th>Model No</th>  
                                                    <th>IMEI Nos</th>  
                                                    <th>Quantity</th>  
                                                    <th>Discount</th>  
                                                    <th>Total Amount</th>  
                                                    <th style="text-align: center"><input type="button"  value="Add" id="add-row" class="btn btn-primary"></th>  
                                                </thead>  
                                                <tbody class="detail">  
                                                    </tbody>  
                                                    <tfoot>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th></th>  
                                                    <th>Total:</th>  
                                                    <th style="text-align:left;" id="total_amount">0</th>
                                                    <th style="text-align:center;"><input type='text' name='total_amount_input' id="total_amount_input" style='display: none'>
                                                    <input type='text' name='no_of_products' id="no_of_products" style='display: none'></th>                                                      
                                                    </tfoot>  
                                                </table>
                                            </div>
                                        </div>
                                        <h3 class="card-title m-t-15">Billing Details</h3>
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mode of Billing *</label>
                                                    <select onchange="yesnoCheck(this)" id="modeofpayment" name="modeofpayment" class="form-control custom-select" required>
                                                        <option>--Select--</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Credit/Debit Card">Credit/Debit Card</option>
                                                        <option value="EMI">EMI</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Bill No *</label>
                                                    <input autocomplete="off" type="text" name="bill_no" class="form-control" required>
                                                </div>
                                            </div>
<?php
        $query_stores = "SELECT `store_id`,`store_name` FROM `stores` ORDER BY `store_id` ASC";
        $result_stores = mysqli_query($db, $query_stores);
            if (!$result_stores) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count_stores = mysqli_num_rows($result_stores);
            if($count_stores === 0){
                //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{?>
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Store Name *</label>
                                                    <select id="modeofpayment" name="store_id" class="form-control custom-select" required>
                                                        <option value="">--Select--</option>
                                                        <?php while($row2 = mysqli_fetch_array($result_stores)){?>
                                                        <option value="<?php echo $row2[0]?>"><?php echo $row2[1]?></option>
                                                        <?php 
                                                        }
                                                            }
                                                        ?>                                                                                                              
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="emi_row" name="emi_row">
                                        <div class="row" >
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">EMI Vendor *</label>
                                                    <input autocomplete="off" type="text" name="emi_vendor" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">No. of Months *</label>
                                                    <input autocomplete="off" min="0" type="number" name="emi_months" class="form-control" >                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">EMI Amount *</label>
                                                    <input autocomplete="off" type="number" name="emi_amount" class="form-control" >                                                
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Comments </label>
                                                    <textarea name="billing_comments" class="form-control form-control-danger" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" name="proceed" id="proceed" class="btn btn-success"><i class="fa fa-check"></i> Proceed</button>
                                        <button type="button" id="cancel" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="https://colorlib.com">Colorlib</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
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
<script>
        function pad2(number) {
             return (number < 10 ? '0' : '') + number;   
        }
        var currentdate = new Date(); 
        var day = currentdate.getDate();
        var month = currentdate.getMonth() + 1;
        var year = currentdate.getFullYear();

        var now = new Date();
        var day1 = ("0" + now.getDate()).slice(-2);
        var month1 = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month1)+"-"+(day1) ;
        document.getElementsByName("invoice_date")[0].value = today;  

        var inv_id = "<?php echo $id_inv ?>";
        document.getElementsByName("invoice_no")[0].value = inv_id;

</script>
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

    <script src="../js/lib/PrintThis/printThis.jquery.json"></script>
    <script src="../js/lib/PrintThis/printThis.js"></script>
    
    
    <script src="../js/billing_js.js"></script>
    <script src="../js/scripts.js"></script>

</body>

</html>
