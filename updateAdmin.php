<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

require 'require/Db.php';
$db = new MyDb();

$data = $db->checkdata($_SESSION['user']);

$message = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password)){
        $message = "Please fill in all fields.";
    } else {
        $adminId = $data['id'];
        $sql = "UPDATE users SET email = ?, password = ? WHERE id = ?";
        $stmt = $db->conn->prepare($sql);
        if($stmt->execute([$email, $password, $adminId])){
            $message = "Updated successfully";
            $_SESSION['user'] = $email;
        } else {
            $message = "Update failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>
    <h2>Update Admin Info</h2>
    
    <?php if(!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

    <form method="post">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" value="<?= htmlspecialchars($data['password']) ?>"><br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</body>
</html>
