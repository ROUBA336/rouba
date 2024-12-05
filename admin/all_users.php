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
    <title>All Users</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>

        /* Table Styles */
.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #ddd;
    cursor: pointer;
}

.table tbody td {
    font-size: 14px;
    color: #333;
}

/* Table Empty State */
.table tbody td[colspan="5"] {
    text-align: center;
    font-style: italic;
    color: #666;
}

/* Responsive Table */
@media screen and (max-width: 768px) {
    .table th, .table td {
        padding: 10px;
        font-size: 12px;
    }
}

    </style>
</head>

<body class="fix-header fix-sidebar">

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
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-b-0">All Users</h4>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM users ORDER BY u_id DESC";
                                $query = mysqli_query($db, $sql);

                                if (mysqli_num_rows($query) > 0) {
                                    while ($rows = mysqli_fetch_assoc($query)) {
                                        echo '<tr>
                                                <td>' . $rows['username'] . '</td>
                                                <td>' . $rows['f_name'] . '</td>
                                                <td>' . $rows['l_name'] . '</td>
                                                <td>' . $rows['phone'] . '</td>
                                                <td>' . $rows['address'] . '</td>
                                              </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">No Users Found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.min.js"></script>

</body>
</html>
