<?php
include("../connection/connect.php");
session_start();

if (isset($_POST['submit'])) {
    // Check if all required fields are filled
    if (empty($_POST['d_name']) || empty($_POST['about']) || empty($_POST['price'])) {
        $error = "All fields must be filled!";
    } else {
        // Handle image upload if a new image is provided
        if (!empty($_FILES['file']['name'])) {
            $fname = $_FILES['file']['name'];
            $temp = $_FILES['file']['tmp_name'];
            $fsize = $_FILES['file']['size'];
            $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            $fnew = uniqid() . '.' . $extension;
            $store = "Res_img/dishes/" . basename($fnew);

            if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
                if ($fsize <= 1024000) { // 1MB limit
                    // Prepare SQL query using prepared statements
                    $sql = $db->prepare("UPDATE dishes SET title=?, slogan=?, price=?, img=? WHERE d_id=?");
                    $sql->bind_param("sssss", $_POST['d_name'], $_POST['about'], $_POST['price'], $fnew, $_GET['menu_upd']);

                    if ($sql->execute() && move_uploaded_file($temp, $store)) {
                        $success = "Record Updated!";
                        header("Location: all_menu.php");
                        exit();
                    } else {
                        $error = "Error updating record or uploading image.";
                    }
                } else {
                    $error = "Image size must be less than 1MB.";
                }
            } else {
                $error = "Invalid image format! Only JPG, PNG, and GIF are allowed.";
            }
        } else {
            // Update record without image
            $sql = $db->prepare("UPDATE dishes SET title=?, slogan=?, price=? WHERE d_id=?");
            $sql->bind_param("ssss", $_POST['d_name'], $_POST['about'], $_POST['price'], $_GET['menu_upd']);

            if ($sql->execute()) {
                $success = "Record Updated!";
                header("Location: all_menu.php");
                exit();
            } else {
                $error = "Error updating record.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu</title>
    <style>
        /* General body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form container */
form {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 600px;
}

/* Heading styles */
h2 {
    text-align: center;
    color: #333;
}

/* Input field styles */
input[type="text"], input[type="file"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="text"]:focus, input[type="file"]:focus {
    border-color: #007bff;
    outline: none;
}

/* Submit button styles */
input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Error and Success messages */
p {
    text-align: center;
    font-weight: bold;
    margin-top: 20px;
}

p[style*="color: red;"] {
    color: red;
}

p[style*="color: green;"] {
    color: green;
}

/* Image preview styling */
img {
    border-radius: 8px;
    margin-bottom: 10px;
}

/* Cancel link styling */
a {
    display: block;
    text-align: center;
    color: #007bff;
    text-decoration: none;
    margin-top: 15px;
}

a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px;
        width: 90%;
    }

    h2 {
        font-size: 18px;
    }
}

    </style>
</head>
<body>
    
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color: green;'>$success</p>"; } ?>

    <form action="" method="post" enctype="multipart/form-data">
        <?php
        $qml = "SELECT * FROM dishes WHERE d_id='$_GET[menu_upd]'";
        $rest = mysqli_query($db, $qml);
        $roww = mysqli_fetch_array($rest);
        ?>
        <label for="d_name">Dish Name:</label>
        <input type="text" name="d_name" value="<?php echo $roww['title']; ?>" required><br>

        <label for="about">About:</label>
        <input type="text" name="about" value="<?php echo $roww['slogan']; ?>" required><br>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?php echo $roww['price']; ?>" required><br>

        <label for="file">Image:</label>
        <?php if (!empty($roww['img'])): ?>
            <img src="Res_img/dishes/<?php echo $roww['img']; ?>" alt="Dish Image" width="150" height="150"><br>
        <?php endif; ?>
        <input type="file" name="file"><br>

        <input type="submit" name="submit" value="Save">

        <!-- Cancel link after Save -->
        <a href="all_menu.php">Cancel</a>
    </form>
</body>
</html>
