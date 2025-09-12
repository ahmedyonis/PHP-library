<?php

class MyDb{
    private $Haddress = "localhost:3306";
    private $DbName = "newData";
    private $User = "root";
    private $pass = "";

    private $connection ="";

    function __construct(){
        $this-> connection = new pdo ("mysql:host=$this->Haddress;dbname=$this->DbName",$this->User,$this->pass);
    }

    function connect(){
        return $this->connection;
    }

    function viewall($table){
        $data = $this->connection->query("select * from $table ");
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }


    function viewone($table,$id){
        $data = $this->connection->query("select * from $table where id = $id");
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    function deleteone($table,$id){
        $data = $this->connection->query("delete from $table where id = $id");
        
    }

    function checkdata($email){
        $data = $this->connection->query("select * from users where email = '$email'");
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    function borrowed_book($table,$user_id){
        $data = $this->connection->query("select * from $table where user_id = $user_id");
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }


    function insert($table,$columns,$values){
        $data = $this->connection->query("insert into $table ($columns) values ($values)");
    }

    function update($table,$id,$data){
        $data = $this->connection->query("update $table set $data where id = $id");
        
    }




}

?>