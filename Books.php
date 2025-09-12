<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="css/Books.css">
</head>
<body>
    
    <?php
        session_start();
        require "db.php";

        if(isset($_POST['add'])){
            $title = $_POST['title'];
            $author = $_POST['author'];
            mysqli_query($conn, "INSERT INTO books (title, author) VALUES ('$title', '$author')");
        }

        if(isset($_GET['delete'])){
            $id = $_GET['delete'];
            mysqli_query($conn, "DELETE FROM books WHERE id=$id");
        }

        $result = mysqli_query($conn, "SELECT * FROM books");
    ?>
        <a href="dashboard.php">Back</a>
        <h2>Books</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Book Title">
            <input type="text" name="author" placeholder="Author">
            <button type="submit" name="add">Add Book</button>
        </form>

        <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Action</th></tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><a href="Books.php?delete=<?= $row['id'] ?>">Delete</a></td>
        </tr>
        <?php } ?>
        </table>
</body>
</html>



