<?php
require_once('./utils/dbconnect.php');
    if(!empty($_GET['id'])){
        $userID = $_GET['id'];
        $query = $connect->prepare("DELETE FROM `users` WHERE `users`.`id_user`= :userID");
        $query->execute(['userID' => $userID]);
        
        sendAlert("Pomyślnie usunięto użytkownika!");
        header('Location: users');
        //getComponent('admin/users');
    }
?>