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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="./styles/Books.css">
</head>
<body class="AdminBooks">    
    <?php
        require "./require/Db.php";

        if(isset($_POST['add'])){
            $name = $_POST['name'];
            $author = $_POST['author'];
            $description = $_POST['description'];
            $db = new MyDb();
            $db->insert('books','name, author, description',"'$name', '$author', '$description'");
        }

        $edit_book = null;
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            // $edit_result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
            // $edit_book = mysqli_fetch_assoc($edit_result);
            $db = new MyDb();
            $edit_book = $db->viewone('books', $id);            
        }

        if(isset($_POST['update'])){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $author = $_POST['author'];
            $description = $_POST['description'];

            // mysqli_query($conn, "UPDATE books 
            // SET title='$title', author='$author', description='$description' 
            // WHERE id=$id");
            $db = new MyDb();
            $db->update('books', "name='$name', author='$author', description='$description'", $id);

            header("Location: AdminBooks.php");
            exit;
        }

        if(isset($_GET['delete'])){
            $id = $_GET['delete'];
            // mysqli_query($conn, "DELETE FROM books WHERE id=$id");
            $db = new MyDb();
            $db->deleteone('books', $id);
        }

        $db = new MyDb();

        $result = $db->viewall('books');
    ?>
        <a href="admin.php">Back</a>
        <h2>Books</h2>
        <form method="POST" class="form-books">
            <input type="hidden" name="id" value="<?= $edit_book['id'] ?? '' ?>">
            <div class="row">
                <input type="text" name="name" placeholder="Book Title" 
                    value="<?= $edit_book['name'] ?? '' ?>">
                <input type="text" name="author" placeholder="Author" 
                    value="<?= $edit_book['author'] ?? '' ?>">
            </div>
            <input type="text" name="description" placeholder="Description"
                value="<?= $edit_book['description'] ?? '' ?>">

            <?php if($edit_book): ?>
                <button type="submit" name="update">Update Book</button><br>
            <?php else: ?>
                <button type="submit" name="add">Add Book</button><br>
            <?php endif; ?>
        </form>



        <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>description</th><th>Action</th></tr>

        <?php 
            foreach($result as $row){
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['author']."</td>";
                echo "<td>".$row['description']."</td>";
                echo '<td><a class="styleEdit" href="AdminBooks.php?edit='.$row['id'].'">Edit</a> 
                <a href="AdminBooks.php?delete='.$row['id'].'">Delete</a></td>';
                echo "</tr>";
            }
        ?>

        </table>
</body>
</html>



