<?php
require_once('./utils/dbconnect.php');
$query = $connect->prepare("SELECT `id_user`,`login`,`email`,`status_name` FROM `users` u LEFT JOIN `statuses` s ON u.`status`=s.`id_status`");
$query->execute();
?>
<section>
<h3>Użytkownicy</h3>
<table>
<thead>
<tr class="primary">
<th>ID</th>
<th>Login</th>
<th>Email</th>
<th>Status</th>
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
    echo '<td><a href="edit_user&id=',$row['id_user'],'" class="accept btn-td">Edytuj</a></td>';
    echo '<td><a href="del_user&id=',$row['id_user'],'" class="reject btn-td">Usuń</a></td>';
    echo '</tr>';
}

?>
</tbody>
</table>
</section>