
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login || Code Camp BD</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
    #buttn {
        color: #fff;
        background-color: #5c4ac7;
    }
    </style>



    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>


<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>

                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                 
                      

                        <?php
						if(empty($_SESSION["user_id"]))
							{
								
							}
						else
							{
									
									
										echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}

						?>
                  
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div style=" background-image: url('images/img/pimg.jpg');">

    <?php
session_start();
include("connection/connect.php"); 
error_reporting(0);

if(isset($_POST['submit'])) {  
    $username = $_POST['username'];  
    $password = $_POST['password'];

    if(!empty($_POST["submit"])) {   
        // SQL query to check credentials
        $loginquery = "SELECT * FROM users WHERE username='$username' AND password='".md5($password)."'"; 
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);

        if(is_array($row)) {
            // Set session variables after login
            $_SESSION["user_id"] = $row['u_id'];
            $_SESSION["username"] = $row['username']; // Save the username to session

            // Redirect to the dishes page
            header("Location: dishes.php");
            exit(); // Make sure the script stops here to avoid further execution
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}
?>


        

        <div class="pen-title">
            < </div>

                <div class="module form-module">
                    <div class="toggle">

                    </div>
                    <div class="form">
                        <h2>Login to your account</h2>
                        <span style="color:red;"><?php echo $message; ?></span>
                        <span style="color:green;"><?php echo $success; ?></span>
                        <form action="" method="post">
                            <input type="text" placeholder="Username" name="username" />
                            <input type="password" placeholder="Password" name="password" />
                            <input type="submit" id="buttn" name="submit" value="Login" />
                        </form>
                    </div>

                    <div class="cta">
   <a href="registration.php" style="color:#5c4ac7;">Create an account</a> | 
    <a href="admi.php" style="color:#5c4ac7;">Login as Admin</a>
</div>
                </div>
                <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


              

                <div class="container-fluid pt-3">
                    <p></p>
                </div>



      


</body>

</html>