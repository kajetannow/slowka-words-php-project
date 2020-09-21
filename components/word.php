<?php
require_once('./utils/dbconnect.php');

$lang = getFirstLang();
$langTrans = getActiveLang();

if(empty($_GET['id'])){
    $query = $connect->prepare("SELECT `word` FROM `words_translation`");
    $allIDs = [];
    $query->execute();
    while($res = $query->fetch()){
        $allIDs[] = $res[0];
    }
    
    $id = $allIDs[array_rand($allIDs)];
    $_GET['id']=$id;
    }else{
        $id=$_GET['id'];
    }

$query = $connect->prepare("SELECT w.name AS 'name', w.definition AS 'def', t.name AS 'translation', t.definition AS 'def_trans', t.ipa_pronoun AS 'pronoun' FROM `words` w RIGHT JOIN `words_translation` wt ON w.id_word = wt.word LEFT JOIN `words` t ON wt.word_translation = t.id_word WHERE w.id_word = :id AND t.lang = :trans");


$query->execute(['id' => $id, 'trans' => $langTrans]);
$word=$query->fetch(PDO::FETCH_ASSOC);

$query = $connect->prepare("SELECT p.`picture` AS 'picture' FROM `pictures` p JOIN `words_pictures` wp ON p.`id_picture` = wp.`picture` WHERE wp.`word` = :id");

$query->execute(['id' => $id]);
$imgs=$query->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="word-desc primary">
<?php 
echo '<p>',getWordState($connect,$_SESSION['user_id'], $id),'</p>';
if(!empty($word)){
echo "<h1>{$word['translation']}</h1>";
echo "<h4><pre>{$word['pronoun']}</pre></h4>";
echo "<h2>{$word['name']}</h2>";
if(!empty($imgs))
    foreach($imgs as $img)
        echo '<img class="word-img" src="',$img['picture'],'"/>';
echo "<p>{$word['def']}</p>";
}
?>
</section>
