<?php
session_start();
include '../php/config.php';

$status1="";
$status="";
$error = "";
$ship_id = "";
$shp_id = "";

$status_shp_product = "";
$error_shp_product = "";

if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}
$ship_id = $_GET['shp_id'];
$shp_id = $ship_id;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $prod_id = mysqli_real_escape_string($db,$_POST['product_id']);
    $prod_name = mysqli_real_escape_string($db,$_POST['product_name']);
    $prod_category = mysqli_real_escape_string($db,$_POST['category']);
    $prod_price = mysqli_real_escape_string($db,$_POST['price']);
    $gst_percentage = mysqli_real_escape_string($db,$_POST['gst']);
    $require_auth = mysqli_real_escape_string($db,$_POST['require_auth']);
    $imei_nos = mysqli_real_escape_string($db,$_POST['imei_nos']);
    $no_in_stock = mysqli_real_escape_string($db,$_POST['quantity']);
    $from_shipment_id = mysqli_real_escape_string($db,$_POST['shipment_id']);
    $date = date('Y-m-d H:i:s');
    //Create your SQL query
    
   $sql_id = "select count(`prod_id`) from `product` where `prod_id` = '$prod_id'";
    $result = mysqli_query($db, $sql_id);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    $value = $row[0];
    if($row['count(`prod_id`)'] === "1"){

        $sql_add = "UPDATE `product` SET `no_in_stock`= `no_in_stock` + $no_in_stock ,`last_edited`= '$date' WHERE `prod_id`='$prod_id';";
            if ($db->query($sql_add) === TRUE) {
                $sql_shipment_product = "INSERT INTO `shipment_products`(`prod_id`, `prod_category`, `prod_name`, `prod_price`, `gst_percentage`, `require_auth`, `imei_nos`, `quantity`, `shipment_id`, `date_created`) VALUES ('$prod_id','$prod_category','$prod_name',$prod_price,$gst_percentage,'$require_auth',$imei_nos,$no_in_stock,'$from_shipment_id','$date')";
                if ($db->query($sql_shipment_product) === TRUE) {                      
                        
                    echo "<SCRIPT type=\"text/javascript\">
                    if (confirm(\"Product stock updated Successfully!! Do you want to add another Product?\")) {
                    window.location.replace(\"./AddProductForShipment.php?shp_id=$from_shipment_id\");
                    }else{
                    window.location.replace(\"./ViewShipments.php\");
                    }</SCRIPT>";

                    
                } else {
                        $status_shp_product = "<div class=\"alert alert-danger\">
                        <strong>Error!</strong> Some Error occurred while adding product. Please contact support team.
                        </div>";
                        $error_shp_product = "Error: " . $sql_shipment_product . "<br>" . $db->error;
                }       

            }else{
                    $status_shp_product = "<div class=\"alert alert-danger\">
                    <strong>Error!</strong> Some Error occurred while updating the stock. Please contact support team.
                    </div>";
                    $error_shp_product = "Error: " . $sql_add . "<br>" . $db->error;
            }

        }else{
            //Create your SQL query
            $sql = "INSERT INTO `product`(`prod_id`, `prod_category`, `prod_name`, `prod_price`, `gst`, `require_auth`, `imei_count`, `no_in_stock`, `from_shipment_id`, `date_created`) VALUES ('$prod_id','$prod_category','$prod_name',$prod_price,$gst_percentage,'$require_auth',$imei_count,$no_in_stock,'$from_shipment_id','$date')";

            if ($db->query($sql) === TRUE) {
                                
                    $sql_shipment_product = "INSERT INTO `shipment_products`(`prod_id`, `prod_category`, `prod_name`, `prod_price`, `gst_percentage`, `require_auth`, `imei_nos`, `quantity`, `shipment_id`, `date_created`) VALUES ('$prod_id','$prod_category','$prod_name',$prod_price,$gst_percentage,'$require_auth',$imei_nos,$no_in_stock,'$from_shipment_id','$date')";

                    if ($db->query($sql_shipment_product) === TRUE) {
                        $status_shp_product = "<div class=\"alert alert-success\">
                                                <strong>Success!</strong> New Product added successfully.
                                                </div>";              
                            echo "<SCRIPT type=\"text/javascript\">
                                    if (confirm(\"New product added Successfully!! Do you want to add another Product?\")) {
                                    window.location.replace(\"./AddProductForShipment.php?shp_id=$from_shipment_id\");
                                    }else{
                                    window.location.replace(\"./ViewShipments.php\");
                                    }</SCRIPT>";

                    } else {
                                $status_shp_product = "<div class=\"alert alert-danger\">
                                <strong>Error!</strong> Some Error occurred while adding product. Please contact support team.
                                </div>";
                                $error_shp_product = "Error: " . $sql_shipment_product . "<br>" . $db->error;
                    } 

            } else {
                        $status_shp_product = "<div class=\"alert alert-danger\">
                        <strong>Error!</strong> Some Error occurred while adding product. Please contact support team.
                        </div>";
                        $error_shp_product = "Error: " . $sql . "<br>" . $db->error;
           }
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
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Shipments</li>
                        <li class="breadcrumb-item active"><a href="AddShipment.php">Add Shipment</a></li>
                        <li class="breadcrumb-item active">Add Products</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Product</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                                    <div class="form-body">
                                        <h3 class="card-title m-t-15">Product Details</h3>
                                        <hr>
                                        <small style="color: red" class="form-control-feedback">* fields are mandatory</small>
                                            <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Product ID *</label>
                                                    <input type="text" name="product_id" class="form-control" >
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Product Name *</label>
                                                    <input type="text" name="product_name" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Category *</label>
                                                    <select name="category" class="form-control custom-select">
                                                        <option value="">--Select--</option>
                                                        <option value="Mobiles">Mobiles</option>
                                                        <option value="Accessories">Accessories</option>
                                                        <option value="Prestige">Prestige</option>
                                                    </select>
                                                    <small class="form-control-feedback"> Select category </small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">IMEI Count *</label>
                                                    <select name="imei_count" class="form-control custom-select">
                                                        <option value=0>0</option>
                                                        <option value=1>1</option>
                                                        <option value=2>2</option>
                                                        <option value=3>3</option>
                                                        <option value=4>4</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Price *</label>
                                                    <input type="number" name="price" class="form-control">
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>GST</label>
                                                    <input type="number" name="gst" class="form-control" >
                                                    <small class="form-control-feedback"> GST in % </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Require Auth *</label>
                                                    <select name="require_auth" class="form-control custom-select">
                                                        <option value="">--Select--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Qunatity *</label>
                                                    <input type="number" name="quantity" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Shipment ID *</label>
                                                    <input type="text" value="<?php echo $ship_id ?>" name="shipment_id" class="form-control" readonly>
                                                </div>
                                            </div>                                            
                                            <!--/span-->
                                        </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <button type="reset" class="btn btn-inverse">Reset</button>
                                    </div>
                                </form>
                                <?php echo $status_shp_product ?>
                                <?php echo $error_shp_product ?>
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
    <!-- All Jquery -->
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

    <script src="../js/scripts.js"></script>

</body>
</html>
