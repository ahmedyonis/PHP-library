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

$id = $_GET['id'] ?? null;

require 'require/Db.php';
$db = new MyDb();

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
        header("Location: admin.php");
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
    <title>Edit Student</title>
</head>
<body>
    <h2>student data</h2>
    <form action="auth.php" method="POST" class="form-group">
        <input type="hidden" name="action" value="updateAdmin">
        <input type="hidden" name="id" value = "<?= $data['id'] ?>">
        <label for="firstname">Firstname:</label><br>
        <input type="text" id="firstname" name="firstname" value="<?= $data['firstname'] ?>" ><br>
        <span style="color:red;"><?= $error['firstname'] ?? ''?></span>
        <br>
        <label for="lastname">Lastname:</label><br>
        <input type="text" id="lastname" name="lastname" value="<?= $data['lastname'] ?>" ><br>
        <span style="color:red;"><?= $error['lastname'] ?? ''?></span>
        <br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $data['email'] ?>" ><br>
        <span style="color:red;"><?= $error['email'] ?? ''?></span>
        <br>
        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password" value="<?= $data['password'] ?>" ><br>
        <span style="color:red;"><?= $error['password'] ?? ''?></span>
        <br>
        <label for="admin">Is admin</label>
        <select name="admin" id="admin">
            <option <?php if ($data['admin'] == 0) echo "selected"; ?> value=0>no</option>
            <option <?php if ($data['admin'] == 1) echo "selected"; ?> value=1>yes</option>
            
        </select><br>
        <input type="submit" value="Update" id="editBtn" class="btn btn-secondary mt-2" >
    </form>
    <h2>borrowed books</h2>
    <table class="table table-striped table-hover book-table">
        <tr>
        <th>book name</th>
        <th>action</th>
        </tr>

    <?php
        if($returnit){
            
                        foreach($returnit as $book){
                            echo "<tr>
                                <td>";
                            echo $book['name'];
                            echo "</td>
                                <td>";
                                
                            echo "<form method='post' >
                        <input type='hidden' name='return' value='{$book['id']}'>
                        <button type='submit' class='btn btn-danger'>Return</button>
                    </form>";

                            echo "</td>
                            </tr>";
                        }
                    } else {
                        echo "No books borrowed.";
                    }
    ?>
    </table>

</body>
</html>