<?php
include "config.php";
error_reporting(0);
session_start();

if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST["password"]);
    $cppassword = md5($_POST["cppassword"]);

    if ($password == $cppassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>alert('Wow! User Registration Completed.');</script>";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cppassword'] = "";
            } else {
                echo "<script>alert('Something went wrong.');</script>";
            }
        } else {
            echo "<script>alert('Email Already Exists.');</script>";
        }
    } else {
        echo "<script>alert('Password and Confirm Password do not match.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p>Register</p>
            <div class="input-group">
                <input type="text" placeholder="User Name" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-group">    
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>  
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="cppassword" value="<?php echo $_POST['cppassword']; ?>" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register-text">Sudah Punya Akun? <a href="index.php">Log In</a></p>
        </form>
    </div>
</body>
</html>
