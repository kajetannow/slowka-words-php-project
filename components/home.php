<?php 
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true')
    include_once('start.php');
//getComponent('start');
else
    include_once('user_panel.php');
    //getComponent('user_panel');
?>