<?php

session_start();
include '../php/config.php';

$status="";
$error = "";
$datarow = "";
if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}

$date = date('Ymd');
$id_shp = 0;    
$query = "SELECT count(`shipment_id`) FROM shipment where `shipment_id` like '%SPM-$date-%'";
$result = mysqli_query($db, $query);
if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
}
$count = mysqli_num_rows($result);
    if($count != 0){
            $row2 = mysqli_fetch_array($result);
            $id_shp = $row2[0]+1;
    }

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $shp_id = mysqli_real_escape_string($db,$_POST['shipment_id']);
    $company_name = mysqli_real_escape_string($db,$_POST['dealer_name']);
    $dealer_address = mysqli_real_escape_string($db,$_POST['dealer_address']);
    $no_of_products = mysqli_real_escape_string($db,$_POST['no_of_products']);
    $total_cost = mysqli_real_escape_string($db,$_POST['total_price']);
    $gst = mysqli_real_escape_string($db,$_POST['gst_paid']);
    $shp_date = mysqli_real_escape_string($db,$_POST['shipment_date']);
    $comments = mysqli_real_escape_string($db,$_POST['comments']);

    $date = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO `shipment`(`shipment_id`, `dealer_name`, `dealer_address`, `no_of_products`, `total_price`, `gst_paid`, `comments`, `created_date`, `shipment_date`) VALUES('$shp_id','$company_name','$dealer_address',$no_of_products,$total_cost,$gst,'$comments','$date','$shp_date');";
   
    if ($db->query($sql) === TRUE) {
        
  $status = "<div class=\"alert alert-success\">
        <strong>Success!</strong> Shipment added successfully.
        </div>";  
  
      echo "<SCRIPT type=\"text/javascript\">
          if (confirm(\"Shipment details added sucessfully. Do you want to add products?\")) {
                    window.location.replace(\"./AddProductForShipment.php?shp_id=$shp_id\");
                    }else{
                    window.location.replace(\"./AddShipment.php\");
                    }</SCRIPT>";    
    } else {
       $status = "<div class='alert alert-danger'><strong>Error!</strong> Some Error occurred while adding product. Please contact support team.</div>";
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
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Shipment</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                                   
                                    <div class="form-body">
                                        <h3 class="card-title m-t-15">Shipments Info</h3>
                                        <hr>
                                       <div class="form-actions">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <button type="reset" class="btn btn-inverse">Reset</button>
                                    </div>
                                        <small style="color: red" class="form-control-feedback">* fields are mandatory</small>

                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Shipment ID *</label>
                                                    <input type="text" id="firstName" class="form-control" name="shipment_id" readonly>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Dealer Name *</label>
                                                    <input type="text" name="dealer_name" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Dealer Address *</label>
                                                    <textarea type="text" name="dealer_address" class="form-control form-control-danger" ></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">No. Of Products *</label>
                                                    <input type="number" name="no_of_products" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Total Price Paid *</label>
                                                    <input type="number" name="total_price" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">GST *</label>
                                                    <input type="number" name="gst_paid" class="form-control form-control-danger" >
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Shipment Date *</label>
                                                    <input type="date" class="form-control" name="shipment_date" placeholder="DD/MM/YYYY">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comments </label>
                                                    <textarea class="form-control" rows="3" name="comments"></textarea>                                                
                                                </div>
                                            </div>
                                           
                                        </div>  
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <button type="reset" class="btn btn-inverse">Reset</button>
                                    </div>
                                </form>
                            <?php echo $status ?>
                            <?php echo $error ?>

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
        document.getElementsByName("shipment_date")[0].value = today;  

        var shp_id = "<?php echo $id_shp ?>";
        document.getElementsByName("shipment_id")[0].value = "SPM-"+year+pad2(month)+pad2(day)+"-"+pad2(shp_id);
        
         function validation(){
            var first_name = document.getElementById()("first_name").value;
            var last_name = document.getElementsByName("last_name")[0].value;
            var gender = document.getElementsByName("gender")[0].value;
            var dob = document.getElementsByName("dob")[0].value;
            var aadharno = document.getElementsByName("aadharno")[0].value;
            var panno = document.getElementsByName("panno")[0].value;
            var address_line = document.getElementsByName("address_line")[0].value;
            var state = document.getElementsByName("state")[0].value;
            var city = document.getElementsByName("city")[0].value;
            var post_code = document.getElementsByName("post_code")[0].value;
            var country = document.getElementsByName("country")[0].value;
            var mobileno1 = document.getElementsByName("mobileno1")[0].value;
            var mobileno2 = document.getElementsByName("mobileno2")[0].value;
            var errors="";
            var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
            var regaadhar = /^([0-9]){12}?$/;
            var regpost_code = /^([0-9]){6}?$/;
            var regmobile = /^([0-9]){10}?$/;

            if(first_name===""||first_name===null){
                errors = errors+"Please enter first name\n";
            }
            if(last_name===""||last_name===null){
                errors = errors+"Please enter last name\n";
            }
            if(gender===""||gender===null){
                errors = errors+"Please enter gender\n";
            }
            if(dob===""||dob===null){
                errors = errors+"Please enter date of birth\n";
            }
            if(aadharno!==""||aadharno!==null){
                if(!regaadhar.test(aadharno)){
                    errors = errors+"Please enter valid Aadhar Number\n";
                }
            }
            if(panno!==""||panno!==null){
                if(!regpan.test(panno)){
                    errors = errors+"Please enter valid PAN Number\n";
                }
            }
            if(address_line===""||address_line===null){
                errors = errors+"Please enter address\n";
            }
            if(city===""||city===null){
                errors = errors+"Please enter city\n";
            }
            if(post_code===""||post_code===null){
                errors = errors+"Please enter post code\n";
            }else if(!regpost_code.test(post_code)){
                errors = errors+"Please enter valid post code\n";
            }
            if(country===""||country===null){
                errors = errors+"Please enter country\n";
            }
            if(mobileno1===""||mobileno1===null){
                errors = errors+"Please enter Mobile No\n";
            }else if(!regmobile.test(mobileno1)){
                errors = errors+"Please enter valid Mobile No\nMobile Number must contain 10 digits\n";
            }
            if(mobileno2!==""||mobileno2!==null){
                if(!regmobile.test(mobileno2)){
                    errors = errors+"Please enter valid Mobile No\nMobile Number must contain 10 digits\n";
                }
            }
            if(errors===""){
                document.getElementById("customer_form").submit();
            }else{
                document.getElementsByName("errors")[0].innerHTML = errors;            
            }
            

    }
</script>

</body>

</html>
