<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if (isset($_POST['submit'])) {
    // Check if required fields are empty
    if (empty($_POST['d_name']) || empty($_POST['about']) || empty($_POST['price']) || empty($_FILES['file']['name'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields must be filled!</strong>
                  </div>';
    } else {
        // Handle image upload
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION)); 
        $fnew = uniqid() . '.' . $extension;
        $store = "Res_img/dishes/" . basename($fnew);

        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if ($fsize >= 1000000) { // Max size 1MB
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max image size is 1024KB. Try a different image.</strong>
                          </div>';
            } else {
                // Insert data into the database
                $sql = "INSERT INTO dishes (rs_id, title, slogan, price, img) VALUES ('" . $_POST['res_name'] . "', '" . $_POST['d_name'] . "', '" . $_POST['about'] . "', '" . $_POST['price'] . "', '" . $fnew . "')";
                if (mysqli_query($db, $sql)) {
                    move_uploaded_file($temp, $store);
                    $success = '<div class="alert alert-success alert-dismissible fade show">
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                 New Dish Added Successfully.
                               </div>';
                    
                    // Redirect to all menu page
                    header("Location: all_menu.php");
                    exit; // Make sure to call exit after the header redirect
                } else {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error adding dish: ' . mysqli_error($db) . '</strong>
                              </div>';
                }
            }
        } else {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid image format! Only JPG, PNG, and GIF are allowed.</strong>
                      </div>';
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Add Menu</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* General body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Main Wrapper Styling */
#main-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Form Container Styling */
.card {
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 900px;
    background-color: #ffffff;
}

/* Form Header */
.card-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
}

/* Form Body Styling */
.card-body {
    padding: 20px;
}

/* Form Group Styling */
.form-group {
    margin-bottom: 15px;
}

/* Input Fields Styling */
.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

/* Focused Input Field Styling */
.form-control:focus {
    border-color: #007bff;
    outline: none;
}

/* File Input Styling */
input[type="file"] {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

/* Button Styling */
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Cancel Button Styling */
.btn-inverse {
    background-color: #ccc;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

.btn-inverse:hover {
    background-color: #999;
}

/* Alert Box Styling */
.alert {
    padding: 15px;
    border-radius: 4px;
    margin-top: 20px;
}

.alert-success {
    background-color: #28a745;
    color: white;
}

.alert-danger {
    background-color: #dc3545;
    color: white;
}

/* Responsive Design for Mobile */
@media (max-width: 768px) {
    .card {
        width: 100%;
        margin: 10px;
    }

    .form-control, input[type="file"], .btn-primary, .btn-inverse {
        width: 100%;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .card-header {
        font-size: 18px;
    }
    
}
/* Form Actions (Save and Cancel buttons) */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.btn-primary {
    width: 48%; /* Adjust button width */
}

.btn-inverse {
    width: 47%; /* Adjust button width */
}

        </style>
</head>

<body class="fix-header">
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
              
                <div class="navbar-collapse">
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link text-muted" href="logout.php">
                                <button class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Log Out</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li><a href="all_users.php"><i class="fa fa-user f-s-20 "></i> Users</a></li>
                        <li><a href="all_menu.php"><i class="fa fa-cutlery" aria-hidden="true"></i> All Menus</a></li>
                        <li><a href="add_menu.php"><i class="fa fa-cutlery" aria-hidden="true"></i> Add Menu</a></li>
                        <li><a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Orders</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="container-fluid">
                <?php echo $error; echo $success; ?>
                <div class="col-lg-12">
                    <div class="card card-outline-primary">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Menu</h4>
                        </div>
                        <div class="card-body">
                            <form action='' method='post' enctype="multipart/form-data">
                                <div class="form-body">
                                    <hr>
                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Dish Name</label>
                                                <input type="text" name="d_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Description</label>
                                                <input type="text" name="about" class="form-control form-control-danger" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row p-t-20">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Price</label>
                                                <input type="text" name="price" class="form-control" placeholder="$" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                                    
                                    <a href="add_menu.php" class="btn btn-inverse">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "include/footer.php" ?>
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
