<!DOCTYPE html>

<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION["adm_id"]))
{
	header('location:index.php');
}
else
{
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Panel</title>

    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


<body class="fix-header">


    <div id="main-wrapper">


        <div class="left-sidebar">

            <div class="scroll-sidebar">

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        
                        <li> <a href="all_users.php"> <span><i class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                    
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery" aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_menu.php">All Menues</a></li>
                                <li><a href="add_menu.php">Add Menu</a></li>


                            </ul>
                        </li>
                        <li> <a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>

                    </ul>
                </nav>

            </div>

        </div>


      
            <script src="js/lib/jquery/jquery.min.js"></script>
            <script src="js/lib/bootstrap/js/popper.min.js"></script>
            <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
            <script src="js/jquery.slimscroll.js"></script>
            <script src="js/sidebarmenu.js"></script>
            <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
            <script src="js/custom.min.js"></script>

</body>

</html>
<?php
}
?>