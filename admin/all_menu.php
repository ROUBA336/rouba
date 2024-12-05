<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>All Orders</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Wrapper -->
    <div id="main-wrapper">
    <div class="header">
            <nav class="navbar navbar-expand-md navbar-light">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="logout.php">
                            <button class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Log Out</button>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Header -->
        <div class="left-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li><a href="all_users.php"><i class="fa fa-user"></i> Users</a></li>
                   
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


        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container">
                <h2 class="text-center my-4">All Menus</h2>
                <div class="card">
               
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Dish</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM dishes ORDER BY d_id DESC";
                                $result = mysqli_query($db, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                                <td>' . htmlspecialchars($row['title']) . '</td>
                                                <td>' . htmlspecialchars($row['slogan']) . '</td>
                                                <td>$' . htmlspecialchars($row['price']) . '</td>
                                                <td><img src="Res_img/dishes/' . htmlspecialchars($row['img']) . '" alt="Dish Image" style="max-width:100px; height:auto;"></td>
                                                <td>
                                                    <a href="update_menu.php?menu_upd=' . $row['d_id'] . '" class="btn btn-sm btn-info">Edit</a>
                                                    <a href="delete_menu.php?menu_del=' . $row['d_id'] . '" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">No menu items found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include "include/footer.php"; ?>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
