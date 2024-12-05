<?php
session_start();
include("connection/connect.php"); 
error_reporting(0);
include_once 'product-action.php'; 

// Process the "Order" button
if (isset($_POST['place_order'])) {
    if (!empty($_SESSION['cart_item'])) {
        $user_id = $_SESSION['user_id'];

        // Insert each cart item into the users_orders table
        foreach ($_SESSION['cart_item'] as $item) {
            $title = $item['title'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $query = "INSERT INTO users_orders (u_id, title, quantity, price) VALUES ('$user_id', '$title', '$quantity', '$price')";
            mysqli_query($db, $query);
        }

        // Clear the cart after placing the order
        unset($_SESSION['cart_item']);

        // Redirect with success message
        header("Location: dishes.php?success=order_placed");
        exit();
    }
}

// Check if the user is logged in
if (empty($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Dishes || Online Food Ordering System - Code Camp BD</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Center the greeting message */
        .greeting {
            text-align: center;
            margin-top: 30px;
        }
    </style>

</head>

<body>
<div class="container">
        <!-- Display greeting if the user is logged in -->
        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            echo '<h2 class="greeting">Hello, ' . htmlspecialchars($_SESSION['username']) . '!</h2>';
        }
        ?>
    </div>

    <div class="page-wrapper">
        <div class="container m-t-30">
            <?php
            // Display success message if order is placed
            if (isset($_GET['success']) && $_GET['success'] == 'order_placed') {
                echo '<div class="alert alert-success">Your order has been placed successfully!</div>';
            }
            ?>
            <div class="row">
                <!-- Your Cart Section -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">Your Cart</h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="order-row bg-white">
                            <div class="widget-body">
                                <?php
                                $item_total = 0;
                                if (isset($_SESSION["cart_item"])) {
                                    foreach ($_SESSION["cart_item"] as $item) {
                                ?>
                                <div class="title-row">
                                    <?php echo $item["title"]; ?>
                                    <a href="dishes.php?action=remove&id=<?php echo $item["d_id"]; ?>">
                                        <i class="fa fa-trash pull-right"></i></a>
                                </div>
                                <div class="form-group row no-gutter">
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control b-r-0" value="$<?php echo $item["price"]; ?>" readonly>
                                    </div>
                                    <div class="col-xs-4">
                                        <input class="form-control" type="text" readonly value="<?php echo $item["quantity"]; ?>">
                                    </div>
                                </div>
                                <?php
                                        $item_total += ($item["price"] * $item["quantity"]);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 class="value"><strong>$<?php echo $item_total; ?></strong></h3>
                                <p>Free Delivery!</p>
                                <form method="post">
                                    <?php
                                    if ($item_total == 0) {
                                        echo '<button type="submit" class="btn btn-danger btn-lg disabled">Order</button>';
                                    } else {
                                        echo '<button type="submit" name="place_order" class="btn btn-success btn-lg active">Order</button>';
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                        <!-- Logout Button -->
                        <div class="widget-body text-center">
                            <a href="logout.php" class="btn btn-warning btn-lg mt-3">Logout</a>
                        </div>
                    </div>
                </div>

                <!-- Menu Section -->
                <div class="col-md-8">
                    <div class="menu-widget" id="2">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">MENU</h3>
                        </div>
                        <div class="collapse in" id="popular2">
                            <?php  
                            $stmt = $db->prepare("SELECT * FROM dishes");
                            $stmt->execute();
                            $products = $stmt->get_result();
                            if ($products->num_rows > 0) {
                                while ($product = $products->fetch_assoc()) {
                            ?>
                            <div class="food-item">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-8">
                                        <form method="post" action='dishes.php?action=add&id=<?php echo $product['d_id']; ?>'>
                                            <div class="rest-logo pull-left">
                                                <a class="restaurant-logo pull-left" href="#">
                                                    <img src="admin/Res_img/dishes/<?php echo $product['img']; ?>" alt="Food logo">
                                                </a>
                                            </div>
                                            <div class="rest-descr">
                                                <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                                <p><?php echo $product['slogan']; ?></p>
                                            </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info">
                                        <span class="price pull-left">$<?php echo $product['price']; ?></span>
                                        <input class="b-r-0" type="text" name="quantity" style="margin-left:30px;" value="1" size="2" />
                                        <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add To Cart" />
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
