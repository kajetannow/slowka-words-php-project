<?php
require_once('./utils/dbconnect.php');
//getUtils('dbconnect');
$query = $connect->prepare("SELECT `id_category`,`category_name` FROM `categories`");
$categories = [];
$query->execute();
while($category = $query->fetch(PDO::FETCH_ASSOC)){
    $categories[] = $category;
};


?>
<section class="primary">
<h1>Kategorie:</h1>
<?php 
if(!empty($categories)){
echo '<ul>';
foreach($categories as $category){
    echo "<li class='block light'><a href=\"./words&cat={$category["id_category"]}\">{$category["category_name"]}</a></li>";
}
echo '</ul>';
}
?>
</section>
