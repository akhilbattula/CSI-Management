<?php
session_start();
include "../php/config.php";

if(!isset($_SESSION['login_user']))
{
    header('Location: ../index.php');
    exit();
}

$id = $_GET['valueID'];
$c_id = $id;

$sql="";
$status="";
$error = "";
$cust_id = "";
$first_name = "";
$address_line = "";
$city = "";
$state = "";
$aadhar = "";
$mobileno1 = "";
$mobileno2 = "";
$panno = "";
$gender = "";
$dob = "";
$country ="";  
$postcode = "";                   
$last_name = "";
$email = "";
$comments ="";
$query = "SELECT `cust_id`, `cust_first_name`, `cust_last_name`, `cust_gender`, `cust_dob`, `cust_address`, `cust_city`, `cust_state`, `cust_country`, `cust_postcode`, `cust_aadhar`, `cust_mobileno1`, `cust_mobileno2`, `cust_panno`,`cust_comments`,`cust_email`, `date_created` FROM `customer` WHERE `cust_id`=$id";
$result = mysqli_query($db, $query);

if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        $error =  "Error in: " . $query . "<br>" . $db->error;                
}
$row = mysqli_fetch_array($result);

$count = mysqli_num_rows($result);
    if($count === 0){
        $error = "<tr><br><br><div class=\"alert alert-danger\">
                    <strong>No Results Found</strong></div></tr>";  
    }else{
       $cust_id = $row[0];
       $first_name = $row[1];
       $last_name = $row[2];
       $gender = $row[3];
       $dd = $row[4];
       $dob = date('Y-m-d', strtotime($dd));
       $address_line = $row[5];
       $city = $row[6];
       $state = $row[7];
       $country = $row[8];
       $postcode = $row[9]; 
       $aadhar = $row[10];
       $mobileno1 = $row[11];
       $mobileno2 = $row[12];
       $panno = $row[13];
       $comments = $row[14];
       $email = $row[15];

    }

if(isset($_POST['update_customer'])){
    $cust_id = mysqli_real_escape_string($db,$_POST['customer_id']);
    $cust_first_name = mysqli_real_escape_string($db,$_POST['first_name']);
    $cust_last_name = mysqli_real_escape_string($db,$_POST['last_name']);
    $cust_gender = mysqli_real_escape_string($db,$_POST['gender']);
    $cust_dob = mysqli_real_escape_string($db,$_POST['dob']);
    $cust_address_line = mysqli_real_escape_string($db,$_POST['address_line']);
    $cust_city = mysqli_real_escape_string($db,$_POST['city']);
    $cust_state = mysqli_real_escape_string($db,$_POST['state']);
    $cust_country = mysqli_real_escape_string($db,$_POST['country']);        
    $cust_postcode = mysqli_real_escape_string($db,$_POST['post_code']);
    $cust_aadhar = mysqli_real_escape_string($db,$_POST['aadharno']);
    $cust_mobileno1 = mysqli_real_escape_string($db,$_POST['mobileno1']);
    $cust_mobileno2 = mysqli_real_escape_string($db,$_POST['mobileno2']);
    $cust_panno = mysqli_real_escape_string($db,$_POST['panno']);
    $cust_email = mysqli_real_escape_string($db,$_POST['email']);
    $edited_by = $_SESSION['login_user'];
    $date = date('Y-m-d H:i:s');

    $cust_first = strtoupper($cust_first_name);
    $cust_last = strtoupper($cust_last_name);
    $sql = "UPDATE `customer` SET `cust_first_name`='$cust_first',`cust_last_name`='$cust_last',`cust_gender`='$cust_gender',`cust_dob`='$cust_dob',`cust_address`='$cust_address_line',`cust_city`='$cust_city',`cust_state`='$cust_state',`cust_country`='$cust_country',`cust_postcode`='$cust_postcode',`cust_aadhar`='$cust_aadhar',`cust_mobileno1`='$cust_mobileno1',`cust_mobileno2`='$cust_mobileno2',`cust_panno`='$cust_panno',`last_edited`='$date',`edited_by`='$edited_by' WHERE `cust_id`=$cust_id";
   
    if ($db->query($sql) === TRUE) {
    
        $status = "<div class=\"alert alert-success\">
  <strong>Success!</strong> Customer Details Updated successfully.
</div>";
        echo "<SCRIPT type='text/javascript'> 
            if (confirm(\"Customer Details Updated Successfully!!\")) {
                        window.location.replace(\"./ViewCustomers.php\");
                    } else {
                        window.location.replace(\"./ViewCustomers.php\");
                    }</SCRIPT>";
    } else {
        $status = "<div class=\"alert alert-danger\">
  <strong>Error!</strong> Some Error occurred while Updating customer details. Please contact support team.
</div>";
        $error =  "Error out: " . $sql . "<br>" . $db->error;
    
    }

}elseif(isset($_POST['cancel'])){
    $cust_id = mysqli_real_escape_string($db,$_POST['customer_id']);
    header('Location: ./CustomerDetails.php?valueID='.$cust_id);
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
                        <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                        <li class="breadcrumb-item active"><a href="ViewCustomers.php">View Customers</a></li>
                        <li class="breadcrumb-item active">Edit Customer Details</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
           <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Edit Customer</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                                    <div class="form-body">
                                        <h3 class="card-title m-t-15">Customer Info</h3>
                                        <hr>
                                        <small style="color: red" class="form-control-feedback">* fields are mandatory</small>
                                        <div class="row">
                                            
                                        
                                        </div>   
                                        <div class="row p-t-20">
                                        <div class="col-md-6">
                                           <div class="form-group">
                                               <label class="control-label">Customer ID *</label>
                                               <input type="text" value="<?php echo $cust_id ?>" style="text-transform: uppercase" name="customer_id" class="form-control" readonly>
                                           </div>
                                        </div>
                                        </div>
                                        <!--/row-->
                                        <div class="row">    
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">First Name *</label>
                                                    <input type="text" value="<?php echo $first_name ?>" style="text-transform: uppercase" name="first_name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Last Name *</label>
                                                    <input type="text" value="<?php echo $last_name ?>" style="text-transform: uppercase" name="last_name" class="form-control" required>
                                                </div>
                                            </div>
                                           
                                            <!--/span-->
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-success">
                                                    <label class="control-label">Gender *</label>
                                                       <input type="text" list="genders" class="form-control  custom-select" name="gender" value="<?php echo $gender ?>" required>
                                                       <datalist id="genders">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                       </datalist>
                                                    <small class="form-control-feedback"> Select your gender </small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Date of Birth *</label>
                                                    <input type="date" class="form-control" name="dob" value="<?php echo $dd ?>" placeholder="DD/MM/YYYY" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Aadhar Number *</label>
                                                    <input value="<?php echo $aadhar ?>" type="number" class="form-control" name="aadharno" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pan Number</label>
                                                    <input type="text" class="form-control" value="<?php echo $panno ?>" style="text-transform: uppercase" name="panno" >
                                                </div>
                                            </div>                                            
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <h3 class="box-title m-t-40">Address</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    <label>Address line *</label>
                                                    <input type="text" class="form-control" name="address_line" value="<?php echo $address_line ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City *</label>
                                                    <input type="text" class="form-control" name="city" value="<?php echo $city ?>" required> 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State *</label>
                                                    <input type="text" class="form-control" name="state" value="<?php echo $state ?>" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Post Code *</label>
                                                    <input type="number" class="form-control" name="post_code" value="<?php echo $postcode ?>" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country *</label>
                                                       <input type="text" list="countries" class="form-control  custom-select" required name="country" value="<?php echo $country ?>">

                                                       <datalist id="countries">
                                                            <option value="India">India</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="USA">USA</option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Mobile No-1 *</label>
                                                    <input type="number" class="form-control" name="mobileno1" size="10" value="<?php echo $mobileno1 ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Mobile No-2</label>
                                                    <input type="number" class="form-control" name="mobileno2" size="10" value="<?php echo $mobileno2 ?>">
                                                </div>
                                            </div>                                            
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Email *</label>
                                                    <input type="email" class="form-control" name="email" value="<?php echo $email ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comments</label>
                                                    <textarea  class="form-control" name="comments"><?php echo $comments ?></textarea>
                                                </div>
                                            </div>                                            
                                        </div>              

                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" name="update_customer" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
                                        <button type="submit" name="cancel" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>
                                <div style="margin-top: 10px">
                                <?php echo $status;?>
                                <?php echo $error;?>
                                </div>
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
