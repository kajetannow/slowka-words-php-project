<section class="primary">
    <h3>Edytowanie użytkownika</h3>
    <form method="POST" class="edit-user">
        <?php
        require_once('./utils/dbconnect.php');
    if(!empty($_GET['id'])){
        $userID = $_GET['id'];
        $query = $connect->prepare("SELECT `id_user`,`login`,`email`,`status`,`status_name` FROM `users` u LEFT JOIN `statuses` s ON u.`status`=s.`id_status` WHERE `id_user`= :userID");
        $query->execute(['userID' => $userID]);
        $user=$query->fetch(PDO::FETCH_ASSOC);
        ?>
        <h4>Zmiana loginu</h4>
        <input type="text" name="login" value="<?php echo $user['login']?>">
        <input type="submit" name="sub_login" value="Zmień login" class="button accept">

        <h4>Zmiana emaila</h4>
        <input type="text" name="email" value="<?php echo $user['email']?>">
        <input type="submit" name="sub_email" value="Zmień email" class="button accept">

        <h4>Zmiana statusu</h4>
        <p>Obecny status: <?php echo $user['status_name']?></p>
        <select name="status">
        <?php 
        $query = $connect->prepare("SELECT * FROM `statuses`");
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            echo "<option value=",$row['id_status'],">",$row['status_name'],"</option>";
        }
        ?>
        </select>
        <input type="submit" name="sub_status" value="Zmień status" class="button accept">
        
        <?php 


updateUser("status", $user, $connect);
updateUser("login", $user, $connect);
updateUser("email", $user, $connect);
}else{
    sendError('Nie podano ID użytkownika');
    echo '<p>Nie podano ID użytkownika</p>';
}
        ?>
    </form>
</section>