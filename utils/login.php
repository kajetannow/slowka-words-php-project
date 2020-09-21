<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    require_once('dbconnect.php');
    
    if(!empty($_POST["username"]) && !empty($_POST["password"]) && isset($_POST['login'])) {
        $errors = [];
        do{
        $username = trim($_POST["username"]);
    
        $query = $connect->prepare("SELECT `id_user`, `login`, `password`, `status` FROM `users`  WHERE `login` = :login");
        $query->execute(['login' => $username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if(empty($user) || !password_verify($_POST['password'], $user['password'])){
            $errors[] = "Niewłaściwe hasło lub login";
            break;
        }

        $query = $connect->prepare("SELECT `status_name` FROM `statuses` WHERE `id_status` = :status");
        $query->execute(['status' => $user['status']]);
        $res = $query->fetch();
        $statusName = $res[0];

        
        if($user['status'] != 2){
            $errors[] = "Użytkownik nie jest aktywny. Status: $statusName";
            break;
        }

        $groups = [];
        $query = $connect->prepare("SELECT `group_name` FROM `users_groups` ug JOIN `groups` g ON ug.`group_id` = g.`id_group` WHERE `user_id` = :id");
        $query->execute(['id' => $user['id_user']]);
        while($res = $query->fetch()){
            $groups[] = $res[0];
        }
        
        
            if(empty($errors)){
            session_start();
            $_SESSION["authenticated"] = 'true';
            $_SESSION["user_id"] = $user['id_user'];
            $_SESSION["user"] = $user['login'];
            $_SESSION["groups"] = $groups;
            header('Location: index.php');
            sendAlert("Zalogowano pomyślnie");
        }
        }while(0);

    if(!empty($errors))
        sendError($errors[0]);
    
}
}
?>