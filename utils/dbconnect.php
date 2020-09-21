<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpasswd = '';
$dbname = 'slowka';
try{
$connect = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8;", $dbuser, $dbpasswd);
}catch (PDOException $e){  
    sendError("Połączenie z bazą nie działa.");
}

?>