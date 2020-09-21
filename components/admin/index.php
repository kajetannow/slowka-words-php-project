<?php 
require_once('./utils/dbconnect.php');
$query = $connect->prepare("SELECT count(`id_user`) FROM `users`");
$query->execute();
$res = $query->fetch();
$usersNum = $res[0];


$query = $connect->prepare("SELECT count(`word`) FROM `words_translation`");
$query->execute();
$res = $query->fetch();
$wordsNum = $res[0];

$query = $connect->prepare("SELECT count(`id_picture`) FROM `pictures`");
$query->execute();
$res = $query->fetch();
$picturesNum = $res[0];

?>

<section class="hello primary">
        <h1>
           Witaj <?php echo $_SESSION['user'] ?>!
        </h1>

        <h3>liczba użytkowników: <?php echo $usersNum ?></h3>
        <h3>liczba słów: <?php echo $wordsNum ?></h3>
        <h3>liczba grafik: <?php echo $picturesNum ?></h3>
</section>