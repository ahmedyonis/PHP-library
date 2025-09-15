<?php


session_start();

    require 'require/Db.php';
    $db = new MyDb();

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }else{

        $data = $db->checkdata($_SESSION['user']);
        if($data['admin'] !== 1){
            header("Location: users.php");
            exit();
        }
    }

$id = $_GET['id'] ?? null;


if($id){
    $_SESSION['id'] = $id;
    $data = $db->viewone('users',$id);
    // $books = $db->books($id);
    $returnit = $db->borrowed_book('books',$id);
}elseif(isset($_SESSION['id'])){
    $data = $db->viewone('users',$_SESSION['id']);
    // $books = $db->books($_SESSION['id']);
    $returnit = $db->borrowed_book('books',$_SESSION['id']);
}


$error=[];
if(isset($_GET['error'])){
    $errorJson = urldecode($_GET['error']);
    $error=json_decode($errorJson,true);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['return'])){
        $book_id = $_POST['return'];
        $db->update('books',"user_id = NULL",$book_id);
        header("Location: edit_student.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/edit_student.css">
</head>
<body>

<div class="form-container">
    <h2>Student Data</h2>
    <form action="auth.php" method="POST" class="form-group">
        <input type="hidden" name="action" value="updateAdmin">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label for="firstname">Firstname:</label>
        <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $data['firstname'] ?>">
        <span class="error-text"><?= $error['firstname'] ?? ''?></span>

        <label for="lastname" class="mt-3">Lastname:</label>
        <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $data['lastname'] ?>">
        <span class="error-text"><?= $error['lastname'] ?? ''?></span>

        <label for="email" class="mt-3">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= $data['email'] ?>">
        <span class="error-text"><?= $error['email'] ?? ''?></span>

        <label for="password" class="mt-3">Password:</label>
        <input type="text" id="password" name="password" class="form-control" value="<?= $data['password'] ?>">
        <span class="error-text"><?= $error['password'] ?? ''?></span>

        <label for="admin" class="mt-3">Is admin:</label>
        <select name="admin" id="admin" class="form-select">
            <option <?php if ($data['admin'] == 0) echo "selected"; ?> value=0>No</option>
            <option <?php if ($data['admin'] == 1) echo "selected"; ?> value=1>Yes</option>
        </select>

        <button type="submit" class="btn btn-secondary mt-4">Update</button>
    </form>
</div>

<h2>Borrowed Books</h2>
<div class="table-responsive">
    <table class="table table-striped table-hover book-table">
        <thead>
            <tr>
                <th>Book Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if($returnit){
                foreach($returnit as $book){
                    echo "<tr>
                            <td>{$book['name']}</td>
                            <td>
                                <form method='post'>
                                    <input type='hidden' name='return' value='{$book['id']}'>
                                    <button type='submit' class='btn btn-danger btn-sm'>Return</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No books borrowed.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
