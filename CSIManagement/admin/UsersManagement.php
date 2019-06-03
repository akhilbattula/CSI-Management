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
        $query = "SELECT `staff_id`, `username`,  `password` FROM `login` ORDER BY `date_created` DESC";
        $result = mysqli_query($db, $query);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count = mysqli_num_rows($result);
            if($count === 0){
                //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result))
                {
                    $query_designation = "SELECT `staff_designation` FROM `staff` where `staff_id`=$row2[0]";
                    $result_designation = mysqli_query($db, $query_designation);
                        if (!$result_designation) {
                            printf("Error: %s\n", mysqli_error($db));
                            exit();
                        }                    
                        $row = mysqli_fetch_array($result_designation);
            $datarow = $datarow."<tr><td><a style=\"text-decoration: underline;\" href=\"./StaffDetails.php?valueID=$row2[0]\">$row2[0]</a></td><td>$row2[1]</td><td>$row2[2]</td><td>$row[0]</td><td><div class=\"dropdown\">
            <button class=\"btn btn-primary dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\">Action
            <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" id=\"edit_user\">Edit</a></li>
              <li><a onClick=\"javascript: return confirm('Do you want to delete record?');\" href=\"../Delete.php?del_id=$row2[0]&del_type=access\">Delete</a></li></ul></div></td></tr>";
                }
        }
    if(isset($_POST['add_access'])){
   
    $staff_id = mysqli_real_escape_string($db,$_POST['staff_id']);
    $staff_username = mysqli_real_escape_string($db,$_POST['username']);
    $staff_password = mysqli_real_escape_string($db,$_POST['password']);
    $staff_access_rights = mysqli_real_escape_string($db,$_POST['access_rights']);

    $sql_staff = "SELECT count(`username`) FROM login WHERE username='$staff_username'";
    $result_staff = mysqli_query($db, $sql_staff);
    if (!$result_staff) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_staff = mysqli_num_rows($result_staff);
    $row_staff = mysqli_fetch_array($result_staff);
   
    if ($row_staff[0]==0) {
        $sql = "INSERT INTO `login`(`staff_id`,`username`,`password`) VALUES ($staff_id,'$staff_username','$staff_password');";

        if ($db->query($sql) === TRUE) {
            $status = "<div class=\"alert alert-success\">
                            <strong>Success!</strong> User access given successfully.
                        </div>";
        } else {
            $status = "<div class=\"alert alert-danger\">
                        <strong>Error!</strong> Access Credentials for Staff ID: <strong>$staff_id</strong> already exists.
                        </div>";
            $error =  "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        $status = "<div class=\"alert alert-danger\">
  <strong>Username already taken!</strong> Please try something else.
</div>";
        $error =  "Error: " . $sql_staff  . "<br>" . $db->error;
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
                                    <li><a href="../php/logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
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
                    <h3 class="text-primary">Staff Management</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="UsersManagement.php">Users Management</a></li>
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
                                <h4 class="m-b-0 text-white">Add User</h4>
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
                                                    <label class="control-label">Staff ID *</label>
                                                    <div >
                                                    <div style="width: 85%;float: left">
                                                        <input type="text" class="form-control" name="staff_id" id="staff_id" readonly>
                                                    </div>
                                                    <div style="width: 15%; text-align: center ;padding-left: 5px; float: right">
                                                        <button type="button" name="search" id="search_staff" onclick="" class="btn btn-success"><i class="fa fa-search"></i> </button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>User Name *</label>
                                                    <input type="text" class="form-control" name="username" >
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Password *</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group has-success">
<?php
        $query = "SELECT `name` FROM `others` WHERE `keyword`='Designations' ORDER BY `name` ASC";
        $result = mysqli_query($db, $query);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count = mysqli_num_rows($result);
            if($count === 0){
                //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{?>
                                                    <label class="control-label">Access Rights *</label>
                                                    <select class="form-control custom-select" name="access_rights">
                                                        <option value="">--Select--</option>
                                                        <?php while($row2 = mysqli_fetch_array($result)){?>
                                                        <option value="<?php echo $row2[0]?>"><?php echo $row2[0]?></option>
                                                        <?php 
                                                        }
                                                            }
                                                        ?>                                                                                                              
                                                    </select>
                                                </div>
                                            </div>
                                            <!--/span-->
                                                                                        
                                            <!--/span-->
                                        </div>
                                   <div id="staff_popup" style="display: none">
<?php
        $datarow1 = "";
        $query_staff = "SELECT `staff_id`, `staff_first_name`,  `staff_address`, `staff_city`, `staff_state`, `staff_mobileno1`, `staff_aadhar`, `staff_gender`,`staff_country`,`staff_postcode`,`staff_mobileno2`,`staff_last_name`,`staff_designation` FROM `staff` ORDER BY `date_created` DESC";
        $result_staff = mysqli_query($db, $query_staff);
            if (!$result_staff) {
                printf("Error: %s\n", mysqli_error($db));
                exit();           }
            $count_staff = mysqli_num_rows($result_staff);
            if($count_staff === 0){
                //$datarow = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
              }else{
                while($row2 = mysqli_fetch_array($result_staff))
                {
                    $staff_name = strtoupper($row2[1]." ".$row2[11]);
                    $mobilenos = $row2[5].", ".$row2[10];
                    $address = $row2[2].", ".nl2br($row2[3]).", ".nl2br($row2[4]).", ".nl2br($row2[8])." - ".nl2br($row2[9]);
                    $datarow1 = $datarow1."<tr><td><a style=\"text-decoration: underline;\" href=\"#\">$row2[0]</a></td><td>$staff_name</td><td>$row2[7]</td><td>$row2[12]</td><td>$mobilenos</td><td><div class=\"dropdown\">
                    <button class=\"btn btn-primary\" name=\"btnselect\"  type=\"button\" data-toggle=\"dropdown\">Select </button></td></tr>";
                }
    }
?>
                        <table name="table1" id="table1" style="margin-bottom: 5px;margin-top: 15px;" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Designation</th>
                                    <th>Mobile No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $datarow1;?>                                          
                            </tbody>
                        </table>
                    </div>
                    <div style="padding-top: 5px">
                        <button type="reset" style="float: right;width: 15%; margin-left: 5px;" name="reset" onclick="" class="btn btn-success"> Reset</button>
                        <button type="submit" style="float: right;width: 20%" name="add_access" onclick="" class="btn btn-success"><i class="fa fa-check"></i> Give Access Rights</button>
                    </div>
                            </div>    
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" data-order='[]' style="margin-bottom: 5px;" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Staff ID</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Access Rights</th>
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
            <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="https://colorlib.com">Colorlib</a></footer>
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
    <script src="../js/cust.js"></script>


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
