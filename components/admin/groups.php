<?php
require_once('./utils/dbconnect.php');
$query = $connect->prepare("SELECT `id_user`, `login`, g.`id_group` AS id_group, `group_name` FROM `users` u JOIN `users_groups` ug ON u.`id_user`=ug.`user_id` JOIN `groups` g ON ug.`group_id`= g.`id_group` ORDER BY g.`id_group`, u.`id_user`");
$query->execute();
?>
<section>
<h3>Grupy użytkowników</h3>
<table>
<thead>
<tr class="primary">
<th>ID</th>
<th>Login</th>
<th>Grupa</th>
<th>ID grupy</th>
<th></th>
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
    echo '<td><a href="group&groupid=',$row['id_group'],'" class="accept btn-td">Edytuj grupę</a></td>';
    echo '<td><a href="del_from_group&id=',$row['id_user'],'&groupid=',$row['id_group'],'" class="reject btn-td">Usuń z grupy</a></td>';
    echo '</tr>';
}

?>
</tbody>
</table>
</section>