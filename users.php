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
if (!$data) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$books = $db->borrowed_book('books',$data['id']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'logout'){
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    if(isset($_POST['return'])){
        $book_id = $_POST['return'];
        $db->update('books',"user_id = NULL, borrowed_until = NULL" ,$book_id);
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
    <title>User Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/UCP.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: 0.3s;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .sidebar.active {
            left: 0;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
        }
        .main-content.shift {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }
    </style>
</head>
<body>
<header id="header" class="mb-3">
    <h1>User Control Panel</h1>
    <div class="header-content">
        <a href="index.php"><button class="btn btn-primary">Back to Main</button></a>
        <form method="post" class="d-inline">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="btn btn-primary">Log out</button>
        </form>
    </div>
</header>

<button class="toggle-btn btn btn-secondary" id="toggleSidebar">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
        <h5 class="mt-2">User Data</h5>
        <hr>
        <form action="auth.php" method="POST">
            <input type="hidden" name="action" value="update">
            <label for="firstname">Firstname:</label><br>
            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($data['firstname']) ?>" disabled class="form-control mb-2">
            <span style="color:red;"><?= $error['firstname'] ?? ''?></span>

            <label for="lastname">Lastname:</label><br>
            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($data['lastname']) ?>" disabled class="form-control mb-2">
            <span style="color:red;"><?= $error['lastname'] ?? ''?></span>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" disabled class="form-control mb-2">
            <span style="color:red;"><?= $error['email'] ?? ''?></span>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($data['password']) ?>" disabled class="form-control mb-2">
            <span style="color:red;"><?= $error['password'] ?? ''?></span>

            <input type="submit" value="Update" id="editBtn" class="btn btn-secondary mt-2" disabled>
        </form>
        <button id="edit" class="btn btn-danger mt-2" onclick="enableEditing()">Edit</button>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="container-fluid p-4">
        <h2 class="mb-4 text-center">User's Books</h2>
        <table class="table table-striped table-hover book-table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Book Name</th>
                    <th scope="col">Book Description</th>
                    <th scope="col">Time Left</th>
                    <th scope="col">Return the Book</th>
                </tr>
            </thead>
            <tbody>
                <?php if($books && count($books) > 0): ?>
                    <?php foreach($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['name']) ?></td>
                            <td><?= htmlspecialchars($book['description']) ?></td>
                            <td id="countdown-<?= $book['id'] ?>"></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="return" value="<?= $book['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Return</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No books borrowed.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<footer id="footer">
    &copy; 2025 ITI Project
</footer>

<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('shift');
    });

    function enableEditing() {
        document.getElementById('firstname').disabled = false;
        document.getElementById('lastname').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('password').disabled = false;
        document.getElementById('editBtn').disabled = false;
    }

    <?php if($books && count($books) > 0): ?>
        <?php foreach($books as $book): ?>
            let countDownDate<?= $book['id'] ?> = new Date("<?= $book['borrowed_until'] ?>").getTime();
            let x<?= $book['id'] ?> = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate<?= $book['id'] ?> - now;

                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown-<?= $book['id'] ?>").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x<?= $book['id'] ?>);
                    document.getElementById("countdown-<?= $book['id'] ?>").innerHTML = "EXPIRED";
                }
            }, 1000);
        <?php endforeach; ?>
    <?php endif; ?>
</script>
</body>
</html>
