<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Orders</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #dee2e6;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #333;
}

.table td {
    background-color: #ffffff;
    color: #555;
}

/* Table Row Hover Effect */
.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Responsive Table */
@media (max-width: 768px) {
    .table th, .table td {
        padding: 8px;
    }
}

        </style>
</head>

<body>

    <!-- Main Wrapper -->
    <div id="main-wrapper">

        <!-- Header -->
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


        <!-- Sidebar -->
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


        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container">

                <h2>All Orders</h2>

                <!-- Orders Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      $sql = "SELECT u.username, u.address, o.title, o.quantity, o.price
                      FROM users_orders o
                      LEFT JOIN users u ON u.u_id = o.u_id";
              
                        $query = mysqli_query($db, $sql);

                        // Check if there are any orders
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                        <td>" . $row['username'] . "</td>
                                        <td>" . $row['title'] . "</td>
                                        <td>" . $row['quantity'] . "</td>
                                        <td>$" . $row['price'] . "</td>
                                        <td>" . $row['address'] . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No Orders Available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>

    </div>



    <!-- Scripts -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
