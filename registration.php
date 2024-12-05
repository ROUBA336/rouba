<?php
// Start session
session_start();
error_reporting(E_ALL);
include("connection/connect.php"); // Include database connection

$message = ""; // Initialize error message variable

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $username = mysqli_real_escape_string($db, trim($_POST['username']));
    $firstname = mysqli_real_escape_string($db, trim($_POST['firstname']));
    $lastname = mysqli_real_escape_string($db, trim($_POST['lastname']));
    $phone = mysqli_real_escape_string($db, trim($_POST['phone']));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    $address = mysqli_real_escape_string($db, trim($_POST['address']));

    // Check if all fields are filled
    if (empty($username) || empty($firstname) || empty($lastname) || empty($phone) || empty($password) || empty($cpassword) || empty($address)) {
        $message = "All fields are required!";
    } else {
        // Check if passwords match
        if ($password !== $cpassword) {
            $message = "Passwords do not match!";
        } elseif (strlen($password) < 6) {
            $message = "Password must be at least 6 characters long!";
        } elseif (strlen($phone) < 8) {
            $message = "Invalid phone number!";
        } else {
            // Check if username already exists
            $check_username = mysqli_query($db, "SELECT username FROM users WHERE username='$username'");
            if (mysqli_num_rows($check_username) > 0) {
                $message = "Username already exists!";
            } else {
                // Insert into database
                $hashed_password = md5($password); // Use password_hash for better security
                $query = "INSERT INTO users (username, f_name, l_name, phone, password, address) 
                          VALUES ('$username', '$firstname', '$lastname', '$phone', '$hashed_password', '$address')";
                if (mysqli_query($db, $query)) {
                    header("Location: index.php");
                    exit;
                } else {
                    $message = "Error inserting data: " . mysqli_error($db);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Reset & General Styles */
       /* Reset & General Styles */
body, html {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
    background-color: #f4f4f9;
    overflow-x: hidden;
}

/* Body Background */
body {
    background: url('images/img/pimg.jpg') no-repeat center center fixed;
    background-size: cover;
}

/* Container Styling */
.container {
    max-width: 500px;
    margin: 100px auto;
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Heading Styling */
h2 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 5px;
    font-size: 14px;
    color: #444;
}

.form-group input,
.form-group textarea {
    width: 90%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #5c4ac7;
    outline: none;
    box-shadow: 0 0 4px rgba(92, 74, 199, 0.4);
}

textarea {
    resize: none;
}

/* Button */
.btn {
    display: inline-block;
    width: 100%;
    padding: 10px;
    background-color: #5c4ac7;
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #4a3b9f;
}

/* Error Message */
.alert {
    padding: 10px;
    margin-bottom: 20px;
    color: white;
    background-color: #e74c3c;
    border-radius: 5px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 480px) {
    .container {
        padding: 15px;
        margin: 50px auto;
    }

    h2 {
        font-size: 20px;
    }

    .btn {
        font-size: 14px;
    }
}

    </style>
</head>
<body style="background: url('images/img/pimg.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="container">
        <h2>Register</h2>
        <?php if ($message): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="cpassword" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn">Register</button>
        </form>
    </div>
</body>
</html>
