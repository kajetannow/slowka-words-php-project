<?php 
session_start();
if(!empty($_SESSION["authenticated"])){
    unset($_SESSION["authenticated"]);
    unset($_SESSION["user"]);
    $_SESSION = array();
}

header("Location: index.php");
getComponent('start');
?>