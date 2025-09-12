<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="css/Books.css">
</head>
<body class="AdminBooks">    
    <?php
        session_start();
        require "db.php";

        if(isset($_POST['add'])){
            $title = $_POST['title'];
            $author = $_POST['author'];
            $description = $_POST['description'];
            mysqli_query($conn, "INSERT INTO books (title, author,description) VALUES ('$title', '$author','$description')");
        }

        $edit_book = null;
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            $edit_result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
            $edit_book = mysqli_fetch_assoc($edit_result);
        }

        if(isset($_POST['update'])){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $description = $_POST['description'];

            mysqli_query($conn, "UPDATE books 
            SET title='$title', author='$author', description='$description' 
            WHERE id=$id");

            header("Location: AdminBooks.php");
            exit;
        }

        if(isset($_GET['delete'])){
            $id = $_GET['delete'];
            mysqli_query($conn, "DELETE FROM books WHERE id=$id");
        }

        $result = mysqli_query($conn, "SELECT * FROM books");
    ?>
        <a href="dashboard.php">Back</a>
        <h2>Books</h2>
        <form method="POST" class="form-books">
            <input type="hidden" name="id" value="<?= $edit_book['id'] ?? '' ?>">
            <div class="row">
                <input type="text" name="title" placeholder="Book Title" 
                    value="<?= $edit_book['title'] ?? '' ?>">
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
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
                <a class="styleEdit" href="AdminBooks.php?edit=<?= $row['id'] ?>">Edit</a> |
                <a href="AdminBooks.php?delete=<?= $row['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        </table>
</body>
</html>



