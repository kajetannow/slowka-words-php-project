<?php
require_once('./utils/dbconnect.php');
if(!empty($_GET['groupid'])){
$groupID = $_GET['groupid'];
$query = $connect->prepare("SELECT `id_user`, `login`, g.`id_group` AS id_group, `group_name` FROM `users` u JOIN `users_groups` ug ON u.`id_user`=ug.`user_id` JOIN `groups` g ON ug.`group_id`= g.`id_group` WHERE g.`id_group` = ? ");
$query->execute([$groupID]);
?>
<section>
<h3>Grupa <?php echo $groupID?></h3>
<table>
<thead>
<tr class="primary">
<th>ID</th>
<th>Login</th>
<th>ID grupy</th>
<th>Grupa</th>
<th></th>
</tr>
</thead>
<tbody>
<?php 
while($row = $query->fetch(PDO::FETCH_ASSOC)){
    echo '<tr>';
    foreach($row as $cell){
        echo "<td>$cell</td>";
    }
    echo '<td><a href="del_from_group&id=',$row['id_user'],'&groupid=',$row['id_group'],'" class="reject btn-td">Usuń</a></td>';
    echo '</tr>';
}

?>
</tbody>
</table>
<form method="POST">
<h4>Dodaj do grupy</h4>
<?php createSelect($connect, 'user', 'users');?>
<input type="submit" name="add" value="Dodaj" class="button accept">
</form>
<?php 
if(isset($_POST['add']) && !empty($_POST['user'])){
    $userID = $_POST['user'];

    $query = $connect->prepare("FROM `users_groups` WHERE `user_id`= :userID AND `group_id`= :groupID");
    $query->execute(['userID' => $userID, 'groupID' => $groupID]);

    if($query->rowCount()>0){
        sendError("Użytkownik o już jest w grupie!");
    }else{
    $query = $connect->prepare("INSERT INTO `users_groups`(`user_id`,`group_id`)  VALUES (:userID, :groupID)");
    $query->execute(['userID' => $userID, 'groupID' => $groupID]);
    sendAlert("Pomyślnie dodano użytownika!");
    header('Location: groups');
    }
}

?>
</section>
<?php } ?>