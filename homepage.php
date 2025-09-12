<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/UCP.css">
    <link rel="stylesheet" href="css/Books.css">
    <title>Home</title>
</head>
<body class="homepage">
    <header id="header">
        <h1>Home</h1>
        <div class="header-links">
            <a href="login.php">Log in</a>
            <a href="login.php">Register</a>
        </div>
    </header>
    </div>

    <div class="main-content" id="mainContent">
    <div class="container-fluid p-4">
    <h2 class="mb-4 text-center">Books available for students to borrow</h2>
    <?php
        session_start();
        require "db.php";
        $result = mysqli_query($conn, "SELECT * FROM books");
    ?>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['author'] ?></td>
            <td><?= $row['description'] ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
    </div>


    <footer id="footer">
        &copy; 2025 ITI Project
    </footer>
    <script src="./script/UCP.js"></script>
</body>
</html>