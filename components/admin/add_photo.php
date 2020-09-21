<section class="primary">
<h3>Dodaj Zdjęcie</h3>
<form method="POST" enctype="multipart/form-data">
<h4>Wybierz słowo:</h4>
<?php
require_once('./utils/dbconnect.php');
$lang = getFirstLang();
        $sql = "SELECT * FROM `words` WHERE `lang` = :lang";
        $bind = ['lang' => $lang];
        createSelectAdv($connect, 'word', $sql, $bind, 'name');
?>
<br><input type='file' name='file' /><br>
<input type="submit" value="Dodaj" name="subm" class="btn accept">
<?php 
if(isset($_POST['subm'])){
    $img = file_get_contents($_FILES['file']['tmp_name']);
    $wordID = $_POST['word'];
    if(empty($img))
        sendError("Brak załącznika!");
    else{
    $imgFileType = $_FILES['file']['type'];
    $imgBase64 = base64_encode($img);
    $imgFormated = "data:$imgFileType;base64,$imgBase64";

    echo "<h3>Dodane zdjęcie:</h3><br>";
    echo '<img class="word-img" src="',$imgFormated,'"/>';
    
    $query = $connect->prepare("INSERT INTO `pictures`(`id_picture`,`picture`) VALUES ('',?)");
    $query->execute([$imgFormated]);

    $imgID = $connect->lastInsertId();
    $query = $connect->prepare("INSERT INTO `words_pictures`(`word`, `picture`) VALUES (?,?)");
    $query->execute([$wordID,$imgID]);
    }
}


?>
</form>
</section>