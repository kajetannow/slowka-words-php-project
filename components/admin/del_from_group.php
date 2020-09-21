<?php
require_once('./utils/dbconnect.php');
    if(!empty($_GET['id']) && !empty($_GET['groupid'])){
        $userID = $_GET['id'];
        $groupID = $_GET['groupid'];
        $query = $connect->prepare("DELETE FROM `users_groups` WHERE `user_id`= :userID AND `group_id`= :groupID LIMIT 1");
        $query->execute(['userID' => $userID, 'groupID' => $groupID]);
        
        sendAlert("Pomyślnie usunięto grupę!");
        header('Location: groups');
        //getComponent('admin/users');
    }
?>