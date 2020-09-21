<?php
require_once('./api.php');

$lang = getFirstLang();
$langTrans = getActiveLang();

    $query = $connect->prepare("SELECT `word` FROM `words_translation`");
    $allIDs = [];
    $query->execute();
    while($res = $query->fetch()){
        $allIDs[] = $res[0];
    }

    $setIDs = [];
    for($i=0;$i<8;$i++){
        $setIDs[]=array_splice($allIDs,array_rand($allIDs),1);
    }
    
    $setIDs = array_column($setIDs, 0);
    //print_r($setIDs);
$in  = str_repeat('?,', count($setIDs) - 1) . '?';
$query = $connect->prepare("SELECT w.name AS 'name', t.name AS 'translation' FROM `words` w RIGHT JOIN `words_translation` wt ON w.id_word = wt.word LEFT JOIN `words` t ON wt.word_translation = t.id_word WHERE w.id_word IN ($in) AND t.lang = ?");

array_push($setIDs, $langTrans);
$query->execute($setIDs);
$words= $query->fetchAll(PDO::FETCH_NUM);
//print_r($words);
header('Content-type:application/json;charset=utf-8');
echo json_encode($words);

?>
