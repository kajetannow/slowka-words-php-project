<section class="primary">
    <h3>Dodaj Tłumaczenie</h3>
    <div class="flex">
    <form method="POST" name="word" class="add-word">
        Kategoria:
        <?php 
        require_once('./utils/dbconnect.php');
        createSelect($connect, 'category', 'categories');
        ?>
        <input type="submit" value="Pokaż słowa z kategorii" name="submit_cat" class="btn accept">
        

    <?php 
    $lang = getFirstLang();
    if(isset($_POST['submit_cat']) && !empty($_POST['category'])){
        $cat = $_POST['category'];
        echo "<input type=\"hidden\" name=\"cat\" value=\"$cat\">";
        $sql = "SELECT * FROM `words` WHERE `category` = :cat AND `lang` = :lang";
        $bind = ['cat' => $cat, 'lang' => $lang];
        createSelectAdv($connect, 'word_index', $sql, $bind, 'name');
        echo '<input type="submit" value="Wybierz słowo" name="edit_word" class="btn accept">';
    }
    if(isset($_POST['edit_word']) && !empty($_POST['word_index']) && !empty($_POST['cat'])){
        $id = $_POST['word_index'];
        $getWord = $connect->prepare("SELECT * FROM `words` WHERE `id_word`= :id AND `lang`=:lang");
        $getWord->execute(['id' => $id, 'lang' => $lang]);
        $word = $getWord->fetch(PDO::FETCH_ASSOC);
        echo 'Język tłumaczenia:';
        createSelect($connect, 'trans_lang', 'langs');
    echo <<< FORM
        <input type="hidden" name="word_id" value="$id">
        <input type="hidden" name="cat" value="$_POST[cat]">
        Słowo: <input type="text" value="$word[name]" disabled> <input type="text" name="translation">
        Opis: <textarea disabled cols="30" rows="4">$word[definition]</textarea> <textarea name="def_trans" cols="30" rows="4"></textarea>
        Wymowa: <input type="text" value="$word[ipa_pronoun]" disabled> <input type="text" name="IPA">
        <input type="submit" value="Dodaj tłumaczenie" name="add_trans" class="btn accept">
    FORM;
    }
    ?>
    
    <?php 
    if(isset($_POST['add_trans']) //&& !empty($_POST['word_id']) && !empty($_POST['translation']) && !empty($_POST['def_trans']) && !empty($_POST['trans_lang']) && !empty($_POST['cat'])){
    ){
        
        $word = trim(mb_strtolower($_POST['translation']));
        $def = trim($_POST['def_trans']);
        if(!empty($_POST['IPA']))
            $IPA = $_POST['IPA'];
        else
            $IPA = NULL;
        $transLang = $_POST['trans_lang'];
        $category = $_POST['cat'];

        $query = $connect->prepare("INSERT INTO `words` (`name`, `definition`, `category`, `lang`, `ipa_pronoun`) VALUES ( :word , :def , :cat , :lang , :ipa )");
        $query->execute(['word' => $word, 'def' => $def, 'cat' => $category, 'lang' => $transLang, 'ipa' => $IPA]);

        $id = $_POST['word_id'];
        $transID = $connect->lastInsertId();

        $query = $connect->prepare("INSERT INTO `words_translation`(`word`, `word_translation`) VALUES (:id,:transID)");
        $query->execute(['id' => $id, 'transID' => $transID]);
    }
    ?>
    </form>
</div>
</section>