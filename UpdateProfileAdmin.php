<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Admin</title>
    <link rel="stylesheet" href="css/UpdateProfileAdmin.css">
</head>
<body>
    <a href="dashboard.php">Back</a><br><br><br>
    <?php
        session_start();
        require "db.php";
        $admin = $_SESSION['admin'];

        if(isset($_POST['update'])){
            $NewUserName = $_POST['username'];
            mysqli_query($conn, "UPDATE admin SET username='$NewUserName' WHERE username='$admin'");

            $NewPass = $_POST['password'];
            mysqli_query($conn, "UPDATE admin SET password='$NewPass' WHERE username='$NewUserName'");
            echo "UserName and Password are Updated Done!";
        }
    ?>
    <form method="POST">
        <h2>Update Profile</h2>
        <input type="text" name="username" placeholder="Enter Your Name">
        <input type="password" name="password" placeholder="New Password">
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>


