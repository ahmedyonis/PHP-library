<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}


$data = $_POST;
$error =[];

require 'require/Db.php';
$db = new MyDb();

if ($data['action']==='signup'){
    $firstname = trim($data['firstname']);
    $lastname = trim($data['lastname']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $repassword = trim($data['repassword']);

    if (empty($firstname)){
        $error["firstname"] = "Enter your first name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)){
        $error["firstname"] = "Only letters and white space allowed";
    }

    if (empty($lastname)){
        $error["lastname"] = "Enter your last name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)){
        $error["lastname"] = "Only letters and white space allowed";
    }

    if (empty($email)){
        $error["email"] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }elseif($db->checkdata($email)){
        $error["email"] = "Email already registered";
    }    
    
    if (empty($password)){
        $error["password"] = "Enter your password";
    } elseif (strlen($password) < 6) {
        $error["password"] = "Password must be at least 6 characters long";
    }

    if (empty($repassword)){
        $error["repassword"] = "Confirm your password";
    } elseif ($password !== $repassword) {
        $error["repassword"] = "Passwords do not match";
    }

    if (empty($error)){
        $columns = "firstname, lastname, email, password";
        $values = "'$firstname', '$lastname', '$email', '$password'";
        $db->insert('users', $columns, $values);
        session_start();
        $_SESSION['user'] = $email;
        header("Location: index.php");
        exit();
    } else {
        $error=json_encode($error);
        $error_encoded = urlencode($error);
        header("Location:login.php?error=$error_encoded");
        }
}

if ($data['action']==='signin'){
    $email = trim($data['email']);
    $password = trim($data['password']);

    if (empty($email)){
        $error["email"] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }elseif(!$db->checkdata($email)){
        $error["email"] = "Email not registered";
    }    
    
    if (empty($password)){
        $error["password"] = "Enter your password";
    } elseif (strlen($password) < 6) {
        $error["password"] = "Password must be at least 6 characters long";
    }elseif ($db->checkdata($email)['password'] !== $password) {
        $error["password"] = "Incorrect password";
    }

    if (empty($error)){
        session_start();
        $_SESSION['user'] = $db->checkdata($email)['email'];
        header("Location: index.php");
        exit();
    } else {
        $error=json_encode($error);
        $error_encoded = urlencode($error);
        header("Location:login.php?error=$error_encoded");
        }
}

if ($data['action']==='update'){
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    $firstname = trim($data['firstname']);
    $lastname = trim($data['lastname']);
    $email = trim($data['email']);
    $password = trim($data['password']);

    if (empty($firstname)){
        $error["firstname"] = "Enter your first name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)){
        $error["firstname"] = "Only letters and white space allowed";
    }

    if (empty($lastname)){
        $error["lastname"] = "Enter your last name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)){
        $error["lastname"] = "Only letters and white space allowed";
    }

    if (empty($email)){
        $error["email"] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }    
    
    if (empty($password)){
        $error["password"] = "Enter your password";
    } elseif (strlen($password) < 6) {
        $error["password"] = "Password must be at least 6 characters long";
    }

    if (empty($error)){
        $currentUser = $db->checkdata($_SESSION['user']);
        $id = $currentUser['id'];
        $updateData = "firstname='$firstname', lastname='$lastname', email='$email', password='$password'";
        $db->update('users', $updateData , $id);
        $_SESSION['user'] = $email;
        header("Location: users.php");
        exit();
    } else {
        $error=json_encode($error);
        $error_encoded = urlencode($error);
        header("Location:users.php?error=$error_encoded");
        }
}

if ($data['action']==='updateAdmin'){
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    $firstname = trim($data['firstname']);
    $lastname = trim($data['lastname']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $id = $data['id'];
    $admin = $data['admin'];

    if (empty($firstname)){
        $error["firstname"] = "Enter your first name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)){
        $error["firstname"] = "Only letters and white space allowed";
    }

    if (empty($lastname)){
        $error["lastname"] = "Enter your last name";
    }else if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)){
        $error["lastname"] = "Only letters and white space allowed";
    }

    if (empty($email)){
        $error["email"] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }   
    
    if (empty($password)){
        $error["password"] = "Enter your password";
    } elseif (strlen($password) < 6) {
        $error["password"] = "Password must be at least 6 characters long";
    }

    if (empty($error)){
        $currentUser = $db->checkdata($_SESSION['user']);
        $updateData = "firstname='$firstname', lastname='$lastname', email='$email', password='$password' , admin = '$admin'";
        $db->update('users', $updateData , $id);
        header("Location: admin.php");
        exit();
    } else {
        $error=json_encode($error);
        $error_encoded = urlencode($error);
        header("Location:edit_student.php?error=$error_encoded");
        }
}

?>