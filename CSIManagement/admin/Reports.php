<!DOCTYPE html>
<html lang="en">
<head>
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
$query = "";
$count1 = "";
$count = 0;
$array_columns = array();
if(isset($_POST['get_report'])){

    $query = "select ";  
    $table_name = mysqli_real_escape_string($db,$_POST['table_name']);
    
    foreach ((array)$_POST['column_names'] as $selectedOption){
        $query = $query."`$selectedOption`, ";
        //$array_columns[] = array($array,$selectedOption);
    }
    $query = substr($query,0,strlen($query)-2)." from `$table_name` where ";

    if(isset($_POST['name'])&&isset($_POST['operator'])&&isset($_POST['value'])){
        $column_name = $_POST['name'];
        $operator = $_POST['operator'];
        $value = $_POST['value'];            

      foreach($value as $x => $n) {        
        $value_datatype = $_POST[$column_name[$x].'_datatype'];            
        if(strcmp($operator[$x],'LIKE')===0){
            if(strpos(strtolower($value_datatype),'int')!==FALSE || strpos(strtolower($value_datatype),'double')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] '%".$value[$x]."%'," ;
            }elseif(strpos(strtolower($value_datatype),'varchar')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] '%".$value[$x]."%',";
            }elseif(strpos(strtolower($value_datatype),'date')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] '%".$value[$x]."%',";
            }
        }else{
            if(strpos(strtolower($value_datatype),'int')!==FALSE || strpos(strtolower($value_datatype),'double')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] $value[$x], ";
            }elseif(strpos(strtolower($value_datatype),'varchar')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] '$value[$x]', ";
            }elseif(strpos(strtolower($value_datatype),'date')!==FALSE){
              $query = $query." `$column_name[$x]` $operator[$x] '$value[$x]', ";
            }            
        }
        
      }
    }
    if(strcmp(substr($query,strlen($query)-6,strlen($query)-1),'where ')===0){
        $query = substr($query,0,strlen($query)-7);    
    }else{
        $query = substr($query,0,strlen($query)-1);
    }
    echo $query ;
    
    if($query !== NULL ||$query !== ''){

        $result = mysqli_query($db, $query);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($db));
            $error = mysqli_error($db);
            exit();
        }
        $count = mysqli_num_rows($result);
        $count1 = mysqli_num_fields($result);
        $datarow = "<table id='example23' data-order='[]' style='margin-bottom: 5px;' class='display nowrap table table-hover table-striped table-bordered' cellspacing='0' width='100%'>
            <thead>
                <tr>";  
        $i = 0;
        while ($i < $count1){
            $text = mysqli_fetch_field_direct($result, $i)->name;
            $str = str_replace('_', ' ', $text);
            $datarow = $datarow."<th>".ucwords($str). "</th>";
            $i++;
        }      
            $datarow = $datarow."</tr></thead><tbody>";
        
        if($count === 0){
         $datarow = "<br><br><div class=\"alert alert-danger\"><strong>No Results Found</strong></div>";
          }else{
                
            while($row2 = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
                $datarow = $datarow."<tr>";
                foreach ($row2 as $data)
                {
                  $datarow = $datarow."<td>". $data . "</td>";
                }
            }
            $datarow = $datarow."</tbody></table>";
        }
    }else{
        $error =  'Unable to fetch the data. Please Try Later';
    }
}

?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <title>Mobi Hub</title>
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
                    <h3 class="text-primary">Reports</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="Reports.php">Reports</a></li>
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
                                <h4 class="m-b-0 text-white">Get a Report</h4>
                            </div>
                            <div class="card-body"> 
                                <div style="margin-top: 10px">
                                <?php //echo $query;?>
                                <?php echo $error;?>
                                </div>
                                <div id="reports_div_1" >
                                    <div class="row" style="margin-top: 15px">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="control-label">Select Section *</label>    
                                                <div>
                                                    <div style="width: 85%;float: left">
                                                            <select class="form-control custom-select" name="table_name">
                                                                <option value="">--Select--</option>
                                                                <option value="customer">Customer</option>
                                                                <option value="product">Products</option>
                                                                <option value="shipment">Shipments</option>
                                                                <option value="shipment_products">Shipment Products</option>
                                                                <option value="invoice">Billing</option>
                                                                <option value="invoice_products">Billing Products</option>
                                                                <option value="needs">Customer Needs</option>
                                                                <option value="staff">Staff</option>
                                                                <option value="log_register">Log Register</option>
                                                                <option value="tickets">Tickets</option>
                                                            </select>
                                                    </div>
                                                    <div style="width: 15%; text-align: center ;padding-left: 5px; float: right">
                                                        <button type="button" name="go_button" id="go_button" class="btn btn-success"> GO </button>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="reports_div_2" style="margin-top: 15px; display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-success">
                                            <label class="control-label">Select Columns *</label>
                                            <select class="form-control custom-select" name="column_names[]" id="column_names" multiple required>
                                                   </select>
                                            <small class="form-control-feedback"> Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</small> 
                                        </div>
                                    </div>                                                    
                                 </div>
                                <h3 class="card-title m-t-15">Filters</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Column Name *</label>
                                            <select class="form-control custom-select" onchange="inputtypecheck(this)" name="column_name" >
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Operator *</label>
                                            <select class="form-control custom-select" name="operator" id="operator">
                                                <option value="">--Select--</option>
                                                <option value="=">Equals to</option>
                                                <option value="!=">Not equals to</option>
                                                <option value="LIKE">Contains</option>
                                                <option value=">">Greater than</option>
                                                <option value="!=">Greater than equal to</option>
                                                <option value="<">Less than</option>
                                                <option value="<=">Less than equals to</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Value </label>
                                            <input type="text" name="value" id="input_readonly" class="form-control" readonly>
                                            <input type="text" name="value" id="input_text" class="form-control" >
                                            <input type="number" name="value" id="input_number" class="form-control" >
                                            <input type="date" name="value" id="input_date" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="table">  
                                    <thead>  
                                        <th>Column Name</th>  
                                        <th>Operator</th>  
                                        <th>Value</th>  
                                        <th style="text-align: center"><input type="button"  value="Add" id="add-row" class="btn btn-primary"></th>  
                                    </thead>  
                                    <tbody class="detail">  
                                    </tbody>  
                                </table>
                                <div class="form-actions" style="margin-top: 15px">
                                    <button type="submit" name="get_report" class="btn btn-success"><i class="fa fa-check"></i> Get Report</button>
<!--                                    <button type="submit" name="cancel" class="btn btn-inverse">Cancel</button>-->
                                </div>
                                </div>
                                <div id="reports_div_3" style="margin-top: 15px; ">
                                <?php echo $datarow ;?>
                                </div>

                            </div>
                        </div>
                        <!--/span-->
                    </div>
            </div>
        </div>
        </form>
                <!-- End PAge Content -->
        </div>
            <!-- End PAge Content -->
            <!-- End Container fluid  -->
        <!-- footer -->
            <!-- End footer -->
        </div>
        <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="https://colorlib.com">Colorlib</a></footer>
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
    <script src="../js/reports.js"></script>


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
