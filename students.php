<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>students</title>
    <link rel="stylesheet" href="css/students.css">
</head>
<body>
    <a href="dashboard.php">Back</a>
    <?php
        include "db.php";

        if(isset($_POST['search'])){
            $student_id = $_POST['student_id'];
            $result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
            $student = mysqli_fetch_assoc($result);
        }
    ?>
        <h2>Search Student</h2>
        <form method="POST">
            <input type="text" name="student_id" placeholder="Enter Student ID">
            <button type="submit" name="search">Search</button>
        </form>

        <?php if(isset($student)){ ?>
        <p>Name: <?= $student['name'] ?></p>
        <p>Student ID: <?= $student['student_id'] ?></p>
    <?php } ?>

    
</body>
</html>
