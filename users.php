<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$error=[];
if(isset($_GET['error'])){
    $errorJson = urldecode($_GET['error']);
    $error=json_decode($errorJson,true);
}

require 'require/Db.php';
$db = new MyDb();

$data = $db->checkdata($_SESSION['user']);

$books = $db->borrowed_book('books',$data['id']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'logout'){
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['return'])){
        $book_id = $_POST['return'];
        $db->update('books',$book_id,"user_id = NULL");
        header("Location: users.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/UCP.css">
    <title>User controll pannel</title>
</head>
<body>
	<header id="header">
        <h1>User Control Panel</h1>
        <div class="header-content">
            <a href="main.php"><button class="btn btn-primary">Back to Main</button></a>
            <form method="post">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn btn-primary">log out</button>
            </form>
            
        </div>
    </header>

    <button class="toggle-btn" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
        <h5 class="mt-2">User Data</h5>
        <hr>
        <form action="auth.php" method="POST">
            <input type="hidden" name="action" value="update">
            <label for="firstname">Firstname:</label><br>
            <input type="text" id="firstname" name="firstname" value="<?= $data['firstname'] ?>" disabled><br>
            <span style="color:red;"><?= $error['firstname'] ?? ''?></span>
            <br>
            <label for="lastname">Lastname:</label><br>
            <input type="text" id="lastname" name="lastname" value="<?= $data['lastname'] ?>" disabled><br>
            <span style="color:red;"><?= $error['lastname'] ?? ''?></span>
            <br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= $data['email'] ?>" disabled><br>
            <span style="color:red;"><?= $error['email'] ?? ''?></span>
            <br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="<?= $data['password'] ?>" disabled><br>
            <span style="color:red;"><?= $error['password'] ?? ''?></span>
            <br>
            <input type="submit" value="Update" id="editBtn" class="btn btn-secondary mt-2" disabled>
        </form>
        <button id="edit" class="btn btn-secondary mt-2" onclick="enableEditing()">Edit</button>
    </div>

    </div>

    <div class="main-content" id="mainContent">
    <div class="container-fluid p-4">
        <h2 class="mb-4 text-center">user's books</h2>

        <table class="table table-striped table-hover book-table">
        <thead class="table-dark">
            <tr>
            <th scope="col">book name</th>
            <th scope="col">book description</th>
            <th scope="col">Return the book</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($books as $book){
                echo "<tr>
                <td>{$book['name']}</td>
                <td>{$book['description']}</td>
                <td>
                    <form method='post' >
                        <input type='hidden' name='return' value='{$book['id']}'>
                        <button type='submit' class='btn btn-danger'>Return</button>
                    </form>
                </td>
                </tr>";
            }

            ?>
        </tbody>
        </table>
    </div>
    </div>


    <footer id="footer">
        &copy; 2025 ITI Project
    </footer>
    <script src="./script/UCP.js">
        function enableEditing() {
    document.getElementById('firstname').disabled = false;
    document.getElementById('lastname').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('editBtn').disabled = false;
}
    </script>
</body>
</html>