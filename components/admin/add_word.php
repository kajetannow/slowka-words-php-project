<section class="primary">
    <h3>Dodaj słowo</h3>
    <div class="flex">
    <form method="POST" name="word" class="add-word">
        Język:
        <?php 
        require_once('./utils/dbconnect.php');
        createSelect($connect, 'lang', 'langs');
        ?>
    
        Słowo: <input type="text" name="word">
        Opis: <textarea name="def" cols="30" rows="4"></textarea>
        Wymowa: <input type="text" name="IPA">
        Kategoria:
        <?php createSelect($connect, 'category', 'categories');?>
    <input type="submit" value="Dodaj" name="subm" class="btn accept">
    <?php 
    if(isset($_POST['subm']) && $_POST['word'] && $_POST['def'] && $_POST['lang'] && $_POST['category']){
        $word = trim(mb_strtolower($_POST['word']));
        $def = trim($_POST['def']);
        if(!empty($_POST['IPA']))
            $IPA = $_POST['IPA'];
        else
            $IPA = NULL;
        $lang = $_POST['lang'];
        $category = $_POST['category'];

        $query = $connect->prepare("INSERT INTO `words` (`name`, `definition`, `category`, `lang`, `ipa_pronoun`) VALUES ( :word , :def , :cat , :lang , :ipa )");
        $query->execute(['word' => $word, 'def' => $def, 'cat' => $category, 'lang' => $lang, 'ipa' => $IPA]);
    }
    ?>
    </form>
</div>
</section>