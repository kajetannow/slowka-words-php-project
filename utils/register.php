<?php
    
    require_once('dbconnect.php');

    if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password_check"]) && !empty($_POST["email"]) && isset($_POST['register'])) {
        do{
        $errors = [];
        $username = trim($_POST["username"]);
        $password = $_POST["password"];
        $password_check = $_POST["password_check"];
        $email = $_POST["email"];


        $query = $connect->prepare("SELECT * FROM `users` WHERE `login`= :login");
        $query->execute(['login' => $username]);

        if($query->rowCount()>0){
            $errors[] = "Użytkownik o nazwie $username już istnieje!";
            break;
        }

        $email = filter_var($email, FILTER_SANITIZE_EMAIL); 
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Niepoprawny mail.";
            break;
        }

        if($password!==$password_check){
            $errors[] = "Hasła różnią się!";
            break;
        }

        if(strlen($password)<8){
            $errors[] = "Hasło jest za krótkie. Wymagane 8 znaków";
            break;
        }

        $password_hash = password_hash($password, PASSWORD_ARGON2ID);
        $query = $connect->prepare("INSERT INTO `users` (`login`,`password`, `email`) VALUES ( :login , :passwd , :email )");
        $query->execute(['login' => $username, 'passwd' => $password_hash, 'email' => $email]);
        $rowId = $connect->lastInsertId();
        
                
        $query = $connect->prepare("INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES ( :id , 2)");
        $query->execute(['id' => $rowId]);
        sendAlert('Zarejestrowano pomyślnie!');
        header("Location: login");
        
        
    }while(0);
    
    if(!empty($errors))
        sendError($errors[0]);
    }
    

?>