<?php 

/**
 * Sends alert message through JS script
 * @param string $msg Message passed to JavaScript handler.
 * @return void
 **/
function sendAlert($msg){
    echo "<script>handleAlert(\"$msg\")</script>";
}

/** 
 * Sends error message through JS script
 * @param string $msg Error message passed to JavaScript handler.
 * @return void
 **/
function sendError($msg){
    echo "<script>handleAlert(\"$msg\",'reject','Błąd!')</script>";
}

/** 
 * Refreshes the current page
 * @param int $delay of refresh [ms] 
 * @return void
 **/
function refreshPage($delay=0){
    echo "<script>setTimeout(()=>window.location.reload(true),$delay)</script>";
}

/** 
 * Returns URL of website from config file
 * @return string the URL of website
 **/
function siteUrl(){
    return config('site_url');
}

/** 
 * Gets CSS file
 * @param string $name name of CSS file
 * @return void
 **/
function getStyle($name){
    echo siteUrl(),'/',config('css_path'),"/$name.css";
}

/** 
 * Gets JavaScript file
 * @param string $name name of JS file
 * @return void
 **/
function getScript($name){
    echo "<script src=",siteUrl(),"/js/$name.js></script>";
}

/** 
 * Gets file from utils folder
 * @param string $name name of file
 * @return void
 **/
function getUtils($name){
    require_once(getcwd().'/'.config('utils_path')."/$name.php");
}

/** 
 * Checks whether user has permission to given page
 * @param string $name name of page
 * @return string 'login' or page name
 **/
function checkPermission($name=''){
    if(empty($name))
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    else
    $page = $name;


    $allPermissions = config("permissions");
    if(isset($_SESSION['groups']) && !empty($_SESSION['groups']))
        $userPermission = $_SESSION['groups'];
    else
        $userPermission = 0;

    if($userPermission === 0){
        $notAuthPages = $allPermissions[0];
        if(!in_array($page, $notAuthPages)){
            header("Location: login");
            return 'login';
        }
        else
            return $page;
    }

    if(in_array($page, $allPermissions['admin'])){
        if(in_array('admin',$userPermission)){
            return $page;
        }
            else{
            header("Location: 404");
            return '404';
        }
    }

    return $page;
}

/** 
 * Obtains php component and includes it
 * @param string $name name of component
 * @return void
 **/
function getComponent($name=''){
if(empty($name))
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
else
    $page = $name;

    $path = getcwd().'/'.config('comp_path')."/$page.php";

    if (!file_exists($path)) {
        $path = getcwd().'/'.config('comp_path')."/404.php";
    }
    include($path);
}

/** 
 * Returns ID of selected First Language. If cookie is not set returns Polish.
 * 
 * @return int the ID of First Language (L1)
 **/
function getFirstLang(){
    if(!empty($_COOKIE['L1']))
    $lang = $_COOKIE['L1'];
    else
    $lang = 1;

    return $lang;
}

/** 
 * Returns ID of selected active language. If cookie is not set returns English.
 * 
 * @return int the ID of active language
 **/
function getActiveLang(){
    if(!empty($_COOKIE['active_lang']))
    $lang = $_COOKIE['active_lang'];
        else
    $lang = 2;

    return $lang;
}

/**
 * Creates Select element with all rows from given table
 * @param PDO $connect Instance of PDO database connection
 * @param string $name HTML attribute "name"
 * @param string $table name of table fetch from database
 * @return void
 **/
function createSelect($connect, $name, $table){
    echo "<select name='$name'>";
        $query = $connect->prepare("SELECT * FROM `$table`");
        $query->execute(['table' => $table]);
        while($row = $query->fetch(PDO::FETCH_NUM)){
            echo "<option value=",$row[0],">",$row[1],"</option>";
        }
        echo '</select>';
}

/**
 * Creates Select element with advanced parameters
 * @param PDO $connect Instance of PDO database connection
 * @param string $name HTML attribute "name"
 * @param string $sql SQL statement
 * @param array $binds binded values in SQL statement
 * @param int|string $value index of column in result of query that would be shown as an option
 * @return void
 **/
function createSelectAdv($connect, $name, $sql, $binds=[], $value=1){
    echo "<select name='$name'>";
        $query = $connect->prepare("$sql");
        $query->execute($binds);
        while($row = $query->fetch()){
            echo "<option value=",$row[0],">",$row[$value],"</option>";
        }
    
        echo '</select>';
}

/**
 * Sets state of word to given user
 * @param PDO $connect Instance of PDO database connection
 * @param int $userID index of user
 * @param int $wordID index of word
 * @param int|NULL $wordID index of word state
 * @return void
 **/
function setWordState($connect, $userID, $wordID, $state){
    $query = $connect->prepare("DELETE FROM `users_words` WHERE `word`=:word AND `user`=:user");
    $query->execute(['user'=>$userID, 'word'=>$wordID]);
    
    $query = $connect->prepare("INSERT INTO `users_words`(`user`, `word`, `word_state`) VALUES (?,?,?)");
    $query->execute([$userID, $wordID, $state]);
}

/**
 * Gets state of word for given user
 * @param PDO $connect Instance of PDO database connection
 * @param int $userID index of user
 * @param int $wordID index of word
 * @return string the state of word for given user
 **/
function getWordState($connect, $userID, $wordID){
    $query = $connect->prepare("SELECT ws.`word_state` AS 'state' FROM `users_words` uw JOIN `words_states` ws ON uw.`word_state` = ws.`id_word_state` WHERE `word`=:word AND `user`=:user");
    $query->execute(['user'=>$userID, 'word'=>$wordID]);
    if($query->rowCount()==0)
        $state = "nieznane";
    else{
        $res = $query->fetch();
        $state = $res[0];
    }
    return $state;
}

/**
 * Updates property of user
 * @param string $prop name of updated property
 * @param array $user array contains all props of user before update
 * @param PDO $connect an instance of PDO database connection
 * @return void
 **/
function updateUser($prop, $user, $connect){
    if(isset($_POST["sub_$prop"]) && !empty($_POST[$prop]) ){
        
        $errors = [];
        do{
            $oldProp = $user[$prop];
            $newProp = $_POST[$prop];
            if($oldProp==$newProp){
                $errors[]="Nowy $prop jest identyczny jak stary.";
                break;
            }

            $query = $connect->prepare("UPDATE `users` SET `$prop`=:newProp WHERE `id_user`=:userID");
            $query->execute(['newProp' => $newProp,'userID' => $user['id_user']]);
            unset($_POST["sub_$prop"]);
            unset($_POST[$prop]);
            refreshPage(3100);
            sendAlert("Pomyślnie zmieniono $prop");
        }while(0);
    if(!empty($errors))
        sendError($errors[0]);
    }
}


/**
 * Checks whether user want to fetch data from API. 
 * If not initalizes template  
 * @return void
 **/
function init(){
    if(!strstr(getcwd(), 'api'))
        require_once(getcwd().'\__template.php');
}
?>