<?php

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
        $_SESSION['user'] = $firstname;
        header("Location: main.php");
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
        $_SESSION['user'] = $db->checkdata($email)['firstname'];
        header("Location: main.php");
        exit();
    } else {
        $error=json_encode($error);
        $error_encoded = urlencode($error);
        header("Location:login.php?error=$error_encoded");
        }
}

?>