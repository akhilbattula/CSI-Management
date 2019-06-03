<?php 
session_start();
include "../php/config.php";

if(!isset($_SESSION['login_user']))
{
    header('Location: ./index.php');
    exit();
}
$datarow="";
$error = "";

$cust_id = $_GET['valueID'];

    $query_customer = "SELECT `cust_id`, `cust_first_name`, `cust_last_name`, `cust_gender`, `cust_dob`, `cust_address`, `cust_city`, `cust_state`, `cust_country`, `cust_postcode`, `cust_aadhar`, `cust_mobileno1`, `cust_mobileno2`, `cust_panno`, `cust_purchasecount`, `date_created`, `last_edited` FROM `customer` WHERE `cust_id`='$cust_id';";
    $result_customer = mysqli_query($db, $query_customer);
    if (!$result_customer) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $count_customer = mysqli_num_rows($result_customer);
    $row_customer = mysqli_fetch_array($result_customer);
    
    
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
                        <li class="breadcrumb-item active">Customers</li>
                        <li class="breadcrumb-item"><a href="ViewCustomers.php">View Customers</a></li>
                        <li class="breadcrumb-item active">Customer Details</li>
                        
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
              <div class="row">
                <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Customer Info</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-body">
                                        <h3 class="box-title m-t-15">Person Info</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Customer ID:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[0] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">First Name:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[1] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Last Name:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[2] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Gender:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[3] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Date of Birth:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[4] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Aadhar No:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[10] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Pan No:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[13] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <h3 class="box-title">Address</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Address Line:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[5] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">City:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[6] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">State:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[7] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Post Code:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[9] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Country:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[8] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Mobile No-1:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[11] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Mobile No-2:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[12] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title">System Information</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Purchase Count:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[14] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Date Created:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555">  <?php echo $row_customer[15] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="text-right col-md-3">Last modified:</label>
                                                    <div class="col-md-9">
                                                        <p style="color: #555555"> <?php echo $row_customer[16] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <a href="EditCustomer.php?valueID=<?php echo $row_customer[0] ?>"><button type="button" name="edit" id="edit" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</button></a>
                                                        <a href="ViewCustomers.php"><button type="button" class="btn btn-inverse">Back</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" >                                                                             
                                                <div class="table-responsive m-t-40">
                                                <div class="card-header">
                                                    <h4 class="m-b-0 text-white">Purchase Details</h4>
                                                </div>                                                
                                                <?php 
                                                    $query = "SELECT `invoice_id`, `no_of_products`, `invoice_status`, `invoice_date`,`total_amount` FROM invoice where cust_id='$row_customer[0]' order by `invoice_date` DESC;";
                                                        $result = mysqli_query($db, $query);
                                                        if (!$result) {
                                                            printf("Error: %s\n", mysqli_error($db));
                                                            exit();
                                                        }
                                                        $count = mysqli_num_rows($result);
                                                    $query_billing = "SELECT `invoice_id`, `no_of_products`, `invoice_status`, `invoice_date`,`total_amount` FROM invoice where cust_id='$row_customer[0]' order by `invoice_date` DESC;";
                                                        $result_billing = mysqli_query($db, $query_billing);
                                                        if (!$result_billing) {
                                                            printf("Error: %s\n", mysqli_error($db));
                                                            exit();
                                                        }
                                                        $count = mysqli_num_rows($result_billing);
                                                            if($count === 0){
                                                                    $error_billing = "<tr><br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div></tr>";
                                                              }else{
                                                                while($row2 = mysqli_fetch_array($result_billing))
                                                                {
                                                                    $datarow = $datarow."<tr><td>$row2[0]</td><td>$row2[1]</td><td>$row2[4]</td><td>$row2[3]</td><td>$row2[2]</td><td>$row2[3]</td><td>$row2[5]</td><td>$row2[6]</td></tr>";
                                                                }
                                                        }
                                                    ?>
                                                    <table id="myTable" style="margin-bottom: 5px;" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice ID</th>
                                                                <th>No. of Products</th>
                                                                <th>Total Amount</th>
                                                                <th>Billing Mode</th>
                                                                <th>Invoice Status</th>
                                                                <th>Invoice Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php echo $datarow;?>                                          
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
    <script>
        var btn = document.getElementById('edit');
        btn.addEventListener('click', function() {
            document.location.href = 'EditCustomer.php?valueID=<?php echo $row_customer[0] ?>';
        });
    </script>
    <script src="../js/lib/jquery/jquery.min.js"></script>
    <script src="../js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery.slimscroll.js"></script>
    <script src="../js/sidebarmenu.js"></script>
    <script src="../js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
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


