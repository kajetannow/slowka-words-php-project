<section class="hello primary">
        <h1>
           Witaj <?php echo $_SESSION['user'] ?>!
        </h1>
        <h3>Przyswojone słówka: 
                <?php 
                require_once('./utils/dbconnect.php');
                $query = $connect->prepare("SELECT COUNT(`word`) FROM `users_words` WHERE `word_state`=2 AND `user`=:user");
                $query->execute(['user'=>$_SESSION['user_id']]);
                if($query->rowCount()==0)
                        $known = 0;
                else{
                        $res = $query->fetch();
                        $known = $res[0];
                }
                echo $known;
                ?>
        </h3>
        <h3>Słówka do powtórzenia: 
                <?php 
                require_once('./utils/dbconnect.php');
                $query = $connect->prepare("SELECT COUNT(`word`) FROM `users_words` WHERE `word_state`=1 AND `user`=:user");
                $query->execute(['user'=>$_SESSION['user_id']]);
                if($query->rowCount()==0)
                        $repeat= 0;
                else{
                        $res = $query->fetch();
                        $repeat = $res[0];
                }
                echo $repeat;
                ?>
        </h3>
        <?php
        /*
        if(empty($_COOKIE['L1']) || empty($_COOKIE['active_lang'])){
                ?>
                <form method="POST" class="flex">
        Język ojczysty:
        <?php 
        require_once('./utils/dbconnect.php');
        createSelect($connect, 'L1','langs');
        ?>
        Język obcy:
        <?php createSelect($connect, 'active_lang','langs'); ?>

        <input type="submit" name="set_langs" value="Ustaw języki" class="btn light">
                </form>
        <?php 
        
        if(isset($_POST['set_langs']) && !empty($_POST['L1']) && !empty($_POST['active_lang'])){
               
                if($_POST['L1'] == $_POST['active_lang']){
                sendError('Wybrany język obcy nie może być taki sam jak ojczysty!');
                }else{
                setcookie('L1', $_POST['L1'], time()+365*24*60*60*100);
                setcookie('active_lang', $_POST['active_lang'], time()+365*24*60*60*100);
                }
                
        }
        
        }
        */        
        ?>
</section>