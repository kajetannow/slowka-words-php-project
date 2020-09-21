<?php
require_once('./utils/dbconnect.php');
//getUtils('dbconnect');
$query = $connect->prepare("SELECT w.id_word AS 'id', w.name AS 'name', w.definition AS 'def', t.name AS 'translation', t.definition AS 'def_trans' FROM `words` w RIGHT JOIN `words_translation` wt ON w.id_word = wt.word LEFT JOIN `words` t ON wt.word_translation = t.id_word WHERE w.category = :category");
$cat = $_GET['cat'];
$words = [];
$query->execute(['category' => $cat]);
while($word = $query->fetch(PDO::FETCH_ASSOC)){
    $words[] = $word;
};


?>
<section class="primary">
<h1>Słowa:</h1>
<?php 
if(!empty($words)){
echo '<ul>';
foreach($words as $word){
    echo "<li><a class='link' href=\"word&id=$word[id]\">{$word['translation']} ({$word['name']}) <em>",getWordState($connect,$_SESSION['user_id'],$word['id']),"</em></a>";
    echo <<< FORM
        <form method="POST">
        <input type="submit" name="status_known_$word[id]" class="btn-status accept" value="Znam"/>
        <input type="submit" name="status_repeat_$word[id]" class="btn-status light" value="Do powtórzenia"/>
        <input type="submit" name="status_unset_$word[id]" class="btn-status reject" value="Nie znam"/>
        </form>
        </li>
    FORM;

    if(isset($_POST["status_known_$word[id]"]))
        setWordState($connect,$_SESSION['user_id'],$word['id'],2);
    if(isset($_POST["status_repeat_$word[id]"]))
        setWordState($connect,$_SESSION['user_id'],$word['id'],1);
    if(isset($_POST["status_unset_$word[id]"]))
        setWordState($connect,$_SESSION['user_id'],$word['id'],NULL);
}
echo '</ul>';
}
?>
</section>
