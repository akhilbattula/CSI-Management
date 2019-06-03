<?php
session_start();
include './php/config.php';

$myusername = $mypassword = "";
$error = "";
$log_status = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db, md5($_POST['password'])); 
    
    $sql = "SELECT id,`staff_id` FROM login WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);

    if($count == 1){
        $id = $row[0];
        echo $id;
        $date = date('Y-m-d H:i:s');
        
        $sql_log = "INSERT INTO `log_register` (`ID`,`staff_id`, `user`, `login_at`) VALUES ('$id','$row[0]','$myusername','$date')";
            if ($db->query($sql_log) === TRUE) {
                $last_id = mysqli_insert_id($db);
                echo $last_id;
                $_SESSION['login_id'] = $last_id;
                $_SESSION['login_at'] = $date;
                $log_status="Login time logged.";
            }else{
                $log_status="Failed to log data.";                
                $error = $sql_log . "<br>" . $db->error;;
            }
        $sql_rights = "SELECT `staff_designation` FROM `staff` WHERE `staff_id` = $row[0]";
        
        $result_rights = mysqli_query($db, $sql_rights);
        $row_rights = mysqli_fetch_array($result_rights);
        
        $rights = $row_rights[0];
        if(strtolower($rights) == 'manager'){
          $_SESSION['login_user'] = $myusername;
           header("location: ./admin/Dashboard.php");
        }

       // $_SESSION['login_user'] = $myusername;
       // header("location: Dashobard.php");

    }else{
        $error = "Login Failed";
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
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Mobi Hub</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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

        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <?php echo $error ?>
                            <div class="login-form">
                                <h4>Login</h4>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                </form>
                            </div>
                            <div style = "font-size:medium; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>

</body>

</html>