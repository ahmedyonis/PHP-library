<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['admin'])){
            header("Location: login.php");
            exit();
        }
        require "db.php";
    ?>

<h2>Admin Dashboard</h2>
<div class="container">
    <div class="card">
        <a href="AdminBooks.php">Manage Books</a>
    </div>
    <div class="card">
        <a href="students.php">Manage Students</a>
    </div>
    <div class="card">
        <a href="borrowed.php">Borrowed Books</a>
    </div>
    <div class="card">
        <a href="UpdateProfileAdmin.php">Update Profile</a>
    </div>
    <div class="card">
        <a href="logout.php">Logout</a>
    </div>
</div>


</body>
</html>


