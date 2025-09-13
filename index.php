<?php
    require "./require/Db.php";
    $db = new MyDb();


    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['action']) && $_POST['action'] === 'logout'){
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['take'])){
            if(isset($_SESSION['user'])){
                $data = $db->checkdata($_SESSION['user']);
                $book_id = $_POST['take'];
                $db->update('books',"user_id = ".$data['id'],$book_id);
                header("Location: index.php");
                exit();
            }else{
                header("Location: login.php");
                exit();
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/home.css">
    <title>ITI Library</title>
</head>
<body class="homepage">
    <header id="header">
        <h1>Home</h1>
        <div class="header-links">
            <?php
                if(isset($_SESSION['user'])){
                    $data = $db->checkdata($_SESSION['user']);
                    echo '<a href="control.php">Welcome, '.$data['firstname']. '</a>';
                    echo '<form method="post">
                                <input type="hidden" name="action" value="logout">
                                <input type="submit" value="log out">
                            </form>';
                }else{
                    echo '<a href="login.php">SignIn/Up</a>';
                }
            ?>
            
        </div>
    </header>
    </div>

    <div class="main-content" id="mainContent">
    <div class="container-fluid p-4">
    <h2 class="mb-4 text-center">Books available for students to borrow</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Take the book</th>
        </tr>
        <?php 
            $avilable_books = $db->available_book('books');

            foreach($avilable_books as $book){
                echo "<tr>";
                echo "<td>".$book['name']."</td>";
                echo "<td>".$book['author']."</td>";
                echo "<td>".$book['description']."</td>";
                echo '<td><form method="post">
                        <button type="submit" class="btn btn-success" name="take" value="'.$book['id'].'">Take</button>
                    </form></td>';
                echo "</tr>";
            }
        ?>
    </table>
    </div>
    </div>


    <footer id="footer">
        &copy; 2025 ITI Project
    </footer>
    <script></script>
</body>
</html>