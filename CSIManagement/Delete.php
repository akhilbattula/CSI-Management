<?php
session_start();

include './php/config.php';
$status = "";
if(!isset($_SESSION['login_user']))
{
    header('Location: ./index.php');
    exit();
}

$id = $_GET['del_id'];
$type = $_GET['del_type'];

    if($type === "customer"){ 
        $sql = "DELETE FROM `customer` WHERE `cust_id`=$id";
        
    if ($db->query($sql) === TRUE) {
        echo "<script type='text/javascript'>window.location.replace(\"admin/ViewCustomers.php\");</script>";

        $status = "<div class=\"alert alert-success\">
            <strong>Success!</strong> Customer details deleted successfully.
            </div>";
    } else {
        
        echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting customer details. Please contact support team.')) {
    window.location.replace(\"admin/ViewCustomers.php\");
}
else {
window.location.replace(\"admin/ViewCustomers.php\");
}
</script>";

        $status = "<div class=\"alert alert-danger\">
  <strong>Error!</strong> Some Error occurred while deleting customer details. Please contact support team.
</div>";
        $error =  "Error: " . $sql . "<br>" . $db->error;
    }
    
    }
    
    else if($type === "product"){
        $sql = "DELETE FROM `product` WHERE `prod_id`=$id";    
    if ($db->query($sql) === TRUE) {
        echo "<script type='text/javascript'>window.location.replace(\"admin/ViewProducts.php\");</script>";

        $status = "<div class=\"alert alert-success\">
            <strong>Success!</strong> Customer details deleted successfully.
            </div>";
    } else {
                echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting customer details. Please contact support team.')) {
    window.location.replace(\"admin/ViewProducts.php\");
}
else {
window.location.replace(\"admin/ViewProducts.php\");
}
</script>";

        $status = "<div class=\"alert alert-danger\">
  <strong>Error!</strong> Some Error occurred while deleting customer details. Please contact support team.
</div>";

        $error =  "Error: " . $sql . "<br>" . $db->error;
    }        
    }
    
    else if($type === "shipment"){
        $sql = "DELETE FROM `shipment` WHERE `shipment_id`='$id'";    
    if ($db->query($sql) === TRUE) {
        echo "<script type='text/javascript'>window.location.replace(\"admin/ViewShipments.php\");</script>";

        $status = "<div class=\"alert alert-success\">
            <strong>Success!</strong> Shipment details deleted successfully.
            </div>";
    } else {
                echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting shipment details. Please contact support team.')) {
    window.location.replace(\"admin/ViewShipments.php\");
}
else {
window.location.replace(\"admin/ViewShipments.php\");
}
</script>";

        $status = "<div class=\"alert alert-danger\">
  <strong>Error!</strong> Some Error occurred while deleting shipment details. Please contact support team.
</div>";

        $error =  "Error: " . $sql . "<br>" . $db->error;
    }        
    }
    
    else if($type === "staff"){
        $sql = "DELETE FROM `staff` WHERE `staff_id`=$id";    
    if ($db->query($sql) === TRUE) {
     //   echo "<script type='text/javascript'>window.location.replace(\"admin/StaffManagement.php\");</script>";

        $status = "<div class=\"alert alert-success\">
            <strong>Success!</strong> Shipment details deleted successfully.
            </div>";
            $sql_login = "DELETE FROM `login` WHERE `staff_id`=$id";    
            if ($db->query($sql_login) === TRUE) {
                echo "<script type='text/javascript'>window.location.replace(\"admin/StaffManagement.php\");</script>";

                $status = "<div class=\"alert alert-success\">
                    <strong>Success!</strong> Shipment details deleted successfully.
                    </div>";
            } else {
                        echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting shipment details. Please contact support team.')) {
            window.location.replace(\"admin/StaffManagement.php\");
            }
            else {
            window.location.replace(\"admin/StaffManagement.php\");
            }
            </script>";

                $status = "<div class=\"alert alert-danger\">
            <strong>Error!</strong> Some Error occurred while deleting shipment details. Please contact support team.
            </div>";

                $error =  "Error: " . $sql_login . "<br>" . $db->error;
                echo $error;
            }        

    } else {
                echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting shipment details. Please contact support team.')) {
                            window.location.replace(\"admin/StaffManagement.php\");
                        }
                        else {
                            window.location.replace(\"admin/StaffManagement.php\");
                        }
                        </script>";

                $status = "<div class=\"alert alert-danger\">
                            <strong>Error!</strong> Some Error occurred while deleting shipment details. Please contact support team.
                          </div>";

                $error =  "Error: " . $sql . "<br>" . $db->error;
                echo $error;
            }        
    }
    
    else if($type === "access"){
        $sql = "DELETE FROM `login` WHERE `staff_id`=$id";    
            if ($db->query($sql) === TRUE) {
                echo "<script type='text/javascript'>window.location.replace(\"admin/UsersManagement.php\");</script>";
                
                $status = "<div class=\"alert alert-success\">
                    <strong>Success!</strong> Shipment details deleted successfully.
                    </div>";
            } else {
                echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting shipment details. Please contact support team.')) {
                            window.location.replace(\"admin/UsersManagement.php\");
                        }
                        else {
                        window.location.replace(\"admin/UsersManagement.php\");
                        }
                        </script>";

                                $status = "<div class=\"alert alert-danger\">
                          <strong>Error!</strong> Some Error occurred while deleting shipment details. Please contact support team.
                        </div>";

                $error =  "Error: " . $sql . "<br>" . $db->error;
            }        
    }

        else if($type === "needs"){
        $sql = "DELETE FROM `needs` WHERE `id`=$id";    
            if ($db->query($sql) === TRUE) {
                echo "<script type='text/javascript'>window.location.replace(\"admin/CustomerNeeds.php\");</script>";
                
                $status = "<div class=\"alert alert-success\">
                    <strong>Success!</strong> Customer Need deleted successfully.
                    </div>";
            } else {
                echo "<script type='text/javascript'>if (confirm('Error!\n Some Error occurred while deleting Customer Need. Please contact support team.')) {
                            window.location.replace(\"admin/CustomerNeeds.php\");
                        }
                        else {
                        window.location.replace(\"admin/CustomerNeeds.php\");
                        }
                        </script>";

                                $status = "<div class=\"alert alert-danger\">
                          <strong>Error!</strong> Some Error occurred while deleting Customer Need. Please contact support team.
                        </div>";

                $error =  "Error: " . $sql . "<br>" . $db->error;
            }        
    }
