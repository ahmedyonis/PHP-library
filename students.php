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

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>students</title>
    <link rel="stylesheet" href="./styles/students.css">
    
</head>
<body>
    <a href="admin.php">Back</a>
    <?php

        

        if(isset($_POST['search'])){
            $student_id = $_POST['student_id'];
            // $result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
            // $student = mysqli_fetch_assoc($result);
            
            $student = $db->viewone('users',$student_id);
            $books = $db->books($student_id);
            
        }
    ?>
        <h2>Search Student</h2>
        <form method="POST">
            <input type="text" name="student_id" placeholder="Enter Student ID">
            <button type="submit" name="search">Search</button>
        </form>

        <?php if(isset($student)){ ?>
            <p>Student ID: <?= $student['id'] ?></p>
            <p>Name: <?= $student['firstname'] ?></p>
            <p>Last Name: <?= $student['lastname'] ?></p>
            <p>Email: <?= $student['email'] ?></p>
            <p>Password: <?= $student['password'] ?></p>
            <p>Admin: <?= $student['admin'] ? 'Yes' : 'No' ?></p>
            <p>Books Borrowed: 
                <?php 
                    if($books){
                        foreach($books as $book){
                            echo $book['name'] . ", ";
                        }
                    } else {
                        echo "No books borrowed.";
                    }
                ?></p>
                <p>Actions: 
                    <a href="edit_student.php?id=<?= $student['id'] ?>">Edit</a> </p>



        
    <?php }
    else{
        $all_students = $db->viewall('users');
        echo "<h2>All Students</h2>";
        echo "<table class='table table-striped table-hover book-table'>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Books Borrowed</th>
                    <th>Actions</th>
                </tr>";
        foreach($all_students as $student){
            $books = $db->books($student['id']);
            echo "<tr>
                    <td>".$student['id']."</td>
                    <td>".$student['firstname']."</td>
                    <td>".$student['lastname']."</td>
                    <td>".$student['email']."</td>
                    <td>".($student['admin'] ? 'Yes' : 'No')."</td>";
                    echo "<td>";
                    foreach($books as $book){
                        echo $book['name']." -- ";
                    }if(empty($books)){
                        echo "No books borrowed.";
                    }
                    echo "</td>";
                    echo "<td><a class='btn btn-success' href='edit_student.php?id=".$student['id']."'>Edit</a></td>";
                echo "</tr>";
        }
        echo "</table>";
    }?>

    
</body>
</html>
