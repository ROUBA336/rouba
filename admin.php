<?php


// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("connection/connect.php");
$message = ''; // Initialize message

// Handle form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Admin login query
        $loginquery = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db, $loginquery);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $_SESSION["adm_id"] = $row['adm_id'];
            header("Location:admin/dashboard.php");
            exit; // Always exit after header redirection
        } else {
            $message = "Invalid Username or Password!";
        }
    } else {
        $message = "Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login || Code Camp BD</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #buttn {
            background-color: #5c4ac7;
            color: white;
            border: none;
            cursor: pointer;
        }

        #buttn:hover {
            background-color: #4a3b9f;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="" method="POST">
            <div class="error"><?php echo $message; ?></div>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" id="buttn" name="submit" value="Login">
        </form>
    </div>
</body>

</html>
