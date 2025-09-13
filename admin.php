<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }else{
        require 'require/Db.php';
        $db = new MyDb();
        $data = $db->checkdata($_SESSION['user']);
        if($data['admin'] !== 1){
            header("Location: users.php");
            exit();
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'logout'){
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>

<h2>Admin Dashboard</h2>
<div class="container">
    <div class="card">
        <a href="AdminBooks.php">Manage Books</a>
    </div>
    <div class="card">
        <a href="students.php">Manage Students</a>
    </div>
    <!-- <div class="card">
        <a href="borrowed.php">Borrowed Books</a>
    </div> -->
    <div class="card">
        <form method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Log Out</button>
        </form>
    </div>
</div>


</body>
</html>


