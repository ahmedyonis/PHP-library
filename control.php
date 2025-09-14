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
        }else{
            header("Location: admin.php");
            exit();
        }
    }

?>