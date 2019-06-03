<?php 
session_start();
include "../php/config.php";

if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}
$status = "";
$error = "";

$datarow = "";
$query_prods = "SELECT `id`, `customer_id`, `product_id`, `product_name`, `quantity`, `comments`, `status`, `date` FROM `needs` order by `created_at` DESC";
$result_prods = mysqli_query($db, $query_prods);
    if (!$result_prods) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_prods = mysqli_num_rows($result_prods);
            if($count_prods === 0){
             $datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result_prods))
                {
             $datarow = $datarow."<tr><td><a href=\"./CustomerDetails.php?valueID=$row2[1]\" target=\"_blank\" style\"color: #00ffFF\">$row2[1]</a></td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[4]</td><td>$row2[5]</td><td>$row2[6]</td><td>$row2[7]</td><td><div class=\"dropdown\">
            <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Action
            <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\">Edit</a></li>
            <li><a onClick=\"javascript: return confirm('Do you want to delete record?');\" href=\"../Delete.php?del_id=$row2[0]&del_type=needs\">Delete</a></li></ul></div></td></tr>"; 
      }
    }
    if(isset($_POST['add_need'])){
   
    $customer_id = mysqli_real_escape_string($db,$_POST['customer_id']);
    $prod_id = mysqli_real_escape_string($db,$_POST['product_ID']);
    $prod_name = mysqli_real_escape_string($db,$_POST['product_name']);
    $quantity = mysqli_real_escape_string($db,$_POST['quantity']);
    $comments = mysqli_real_escape_string($db,$_POST['comments']);
    $status = mysqli_real_escape_string($db,$_POST['status']);
    $timestamp = date('Y-m-d H:i:s');
    $date = date('Y-m-d');

        $sql = "INSERT INTO `needs`(`customer_id`,`product_id`,`product_name`,`quantity`,`comments`,`status`,`date`,`created_at`) VALUES ($customer_id,'$prod_id','$prod_name',$quantity,'$comments','$status','$date','$timestamp');";

        if ($db->query($sql) === TRUE) {
        echo "<script type='text/javascript'>if (confirm('Success!\n Customer Need added sucessfully.')) {
                    window.location.replace(\"admin/CustomerNeeds.php\");
                }else{
                    window.location.replace(\"admin/CustomerNeeds.php\");
                }
                </script>";
        } else {
            $status = "<div class=\"alert alert-danger\">
                            <strong>Error!</strong> Access Credentials for Staff ID: <strong>$staff_id</strong> already exists.
                        </div>";
            $error =  "Error: " . $sql . "<br>" . $db->error;
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
                                    <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
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
                        <li> <a class="active" href="CustomerNeeds.php" aria-expanded="false"><i class="fa fa-sticky-note"></i><span class="hide-menu">Customer Needs </span></a></li>          
                        <li> <a href="RequiredStock.php" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Stock Required </span></a></li>          
                        <li> <a href="StaffManagement.php" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">Staff Management </span></a></li>          
                        <li> <a href="UsersManagement.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Users Management </span></a></li>          
                        
                        <li class="nav-label">Issue Tracking</li>
                        <li> <a href="TicketingSystem.php" aria-expanded="false"><i class="fa fa-ticket"></i><span class="hide-menu">Ticketing System </span></a></li>
                        
                        
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
                    <h3 class="text-primary">Customer Needs</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="UsersManagement.php">Customer Needs</a></li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
            <small style="color: red" class="form-control-feedback" name="errors"></small>

            <form id="customer_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                    <div class="form-body">
             <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-primary">
                           <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Requirement</h4>
                            </div>
                            <div class="card-body"> 
                                <div style="margin-top: 10px">
                                <?php echo $status;?>
                                <?php //echo $error;?>
                                </div>
                                <div id="add_access_modal" >
                                <div class="row" style="margin-top: 15px">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Customer ID *</label>
                                                    <div>
                                                    <div style="width: 85%;float: left">
                                                        <input type="text" class="form-control" name="customer_id" id="customer_id" required="true" readonly="true" >
                                                    </div>
                                                    <div style="width: 15%; text-align: center ;padding-left: 5px; float: right">
                                                        <button type="button" name="search_customer_needs" id="search_customer_needs" onclick="" class="btn btn-success"><i class="fa fa-search"></i> </button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Product ID </label>
                                                    <div>
                                                    <div style="width: 85%;float: left">
                                                        <input type="text" class="form-control" name="product_ID" id="product_id" readonly>
                                                    </div>
                                                    <div style="width: 15%; text-align: center ;padding-left: 5px; float: right">
                                                        <button type="button" name="search_product_needs" id="search_product_needs" onclick="" class="btn btn-success"><i class="fa fa-search"></i> </button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Product Name *</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Quantity *</label>
                                                    <input type="number" class="form-control" name="quantity" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Comments</label>
                                                    <textarea  class="form-control" name="comments"></textarea>
                                                </div>
                                            </div>                                                                                       
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <?php
                                                            $query_status = "SELECT `name` FROM `others` WHERE `keyword`='Needs_Status' ORDER BY `name` ASC";
                                                            $result_status = mysqli_query($db, $query_status);
                                                                if (!$result_status) {
                                                                    printf("Error: %s\n", mysqli_error($db));
                                                                    exit();           }
                                                                $count = mysqli_num_rows($result_status);
                                                                if($count === 0){
                                                                    //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
                                                                  }else{?>
                                                    <label class="control-label">Access Rights *</label>
                                                    <select class="form-control custom-select" name="status" required>
                                                        <option value="">--Select--</option>
                                                        <?php while($row2 = mysqli_fetch_array($result_status)){?>
                                                        <option value="<?php echo $row2[0]?>"><?php echo $row2[0]?></option>
                                                        <?php 
                                                        }
                                                            }
                                                        ?>                                                                                                              
                                                    </select>
                                                </div>
                                            </div>                                                                                       
                                    </div>
                                        <div style="margin-top: 10px;">
                                            <button type="submit" style="float: right;width: 20%;margin-bottom: 10px" name="add_need" onclick="" class="btn btn-success"><i class="fa fa-check"></i> Add Need</button>
                                        </div>
                                    <div id="customer_popup" style="display: none">
                                        <?php
                                                $datarow_customer = "";
                                                $query_customer = "SELECT `cust_id`, `cust_first_name`,  `cust_address`, `cust_city`, `cust_state`, `cust_mobileno1`, `cust_aadhar`, `cust_purchasecount`,`cust_country`,`cust_postcode`,`cust_mobileno2`,`cust_last_name` FROM `customer` ORDER BY `cust_id` DESC";
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
                                                            $cust_name = strtoupper($row2[1]." ".$row2[11]);
                                                            $mobilenos = $row2[5].", ".$row2[10];
                                                            $address = $row2[2].", ".nl2br($row2[3]).", ".nl2br($row2[4]).", ".nl2br($row2[8])." - ".nl2br($row2[9]);
                                                            $datarow_customer = $datarow_customer."<tr><td><a style=\"text-decoration: underline;\" href=\"#\">$row2[0]</a></td><td>$cust_name</td><td>$address</td><td>$mobilenos</td><td>$row2[6]</td><td>$row2[7]</td><td><div class=\"dropdown\">
                                                            <button class=\"btn btn-primary\" name=\"btnselect_customer\"  type=\"button\" data-toggle=\"dropdown\">Select </button></td></tr>";
                                                }
                                                }
                                        ?>
                                       
                                        <table name="myTable" id="myTable" style="margin-bottom: 5px;margin-top: 15px;" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                    <div id="product_popup" style="display: none">
                                        <?php
                                                $datarow_product = "";
                                                $query_product = "SELECT `prod_id`, `prod_name`, `prod_category`, `prod_price`, `gst` FROM `product` order by `date_created` DESC";
                                                $result_product = mysqli_query($db, $query_product);
                                                    if (!$result_product) {
                                                        printf("Error: %s\n", mysqli_error($db));
                                                        exit();           }
                                                    $count_product = mysqli_num_rows($result_product);
                                                    if($count_product === 0){
                                                        //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
                                                      }else{
                                                        while($row2 = mysqli_fetch_array($result_product))
                                                        {
                                                            $datarow_product = $datarow_product."<tr><td><a style=\"text-decoration: underline;\" href=\"#\">$row2[0]</a></td><td>$row2[1]</td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[4]</td><td><div class=\"dropdown\">
                                                            <button class=\"btn btn-primary\" name=\"btnselect_product\"  type=\"button\" data-toggle=\"dropdown\">Select </button></td></tr>";
                                                }
                                                }
                                        ?>
 
                                        <table name="newTable" id="newTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Product ID</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>GST %</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $datarow_product;?>                                          
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-40">
                                    <table id="needTable" name="needTable" style="margin-bottom: 5px;" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Customer ID</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Comments</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $datarow;?>                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                <!-- End PAge Content -->
            </div>
     </div>
       <!-- End PAge Content -->
            <!-- End Container fluid  -->
                    </div>
            </form>
            </div>
       <!-- footer -->
            <footer class="footer"> Template designed by <a href="https://colorlib.com">Colorlib.</a> Application developed by Akhil Battula</footer>
            <!-- End footer -->
             </div>
        <!-- End Page wrapper  -->
    </div>
   
    <!-- End Wrapper -->
    <!-- All Jquery -->
    
    
    <script src="../js/lib/jquery/jquery.min.js"></script>
    <script src="../js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery.slimscroll.js"></script>
    <script src="../js/sidebarmenu.js"></script>
    <script src="../js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/needs.js"></script>


    <script src="../js/lib/datatables/datatables.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="../js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="../js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="../js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="../js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="../js/lib/datatables/datatables-init.js"></script>

</body>
</html>
