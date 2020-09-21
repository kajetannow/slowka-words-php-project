<?php
require_once('./utils/dbconnect.php');

$lang = getFirstLang();
$langTrans = getActiveLang();

$correct = false;

if(empty($_GET['id'])){
$query = $connect->prepare("SELECT `word` FROM `words_translation`");
$allIDs = [];
$query->execute();
while($res = $query->fetch()){
    $allIDs[] = $res[0];
}

$id = $allIDs[array_rand($allIDs)];
}else{
    $id=$_GET['id'];
}


$getWord = $connect->prepare("SELECT * FROM `words` WHERE `id_word`= :id AND `lang`=:lang");
$getWord->execute(['id' => $id, 'lang' => $lang]);
$word = $getWord->fetch(PDO::FETCH_ASSOC);


$query = $connect->prepare("SELECT `word_translation` FROM `words_translation` WHERE `word`= :id");
$query->execute(['id' => $id]);
$res = $query->fetch();
$translationID = $res[0];


$getWord->execute(['id' => $translationID, 'lang' => $langTrans]);
$translation = $getWord->fetch(PDO::FETCH_ASSOC);

?>
<section class="word-desc primary">
<?php 
echo "<h1>{$translation['name']}";
if(!empty($_POST['gap']) || isset($_POST['subm'])){
    $correct = trim(mb_strtolower($_POST['gap']))==mb_strtolower($word['name']);
    if($correct){
        echo '<span class="block badge accept">Poprawnie!</span>';
    }else{
        echo '<span class="block badge reject">Błędnie!</span>';
    }
}
echo '</h1>';
echo "<h4>{$translation['ipa_pronoun']}</h4>";
if(!empty($_POST['gap']) || isset($_POST['subm'])){
    if($correct){
        echo "<h2>{$word['name']}</h2>";
        echo "<p>{$word['definition']}</p>";
    }
}

if(!$correct){
?>

<form method="POST" action="fill&id=<?php echo $id ?>">
    <input type="text" name="gap" autocomplete="off">
    <input type="submit" name="subm" value="Sprawdź" class="btn light">
</form>
</section>
<?php 
}else{
?>
    <form method="POST" action="fill">
    <input type="submit" name="rand" value="Losuj kolejne słowo" class="btn light">
    </form>
<?php
}
?>