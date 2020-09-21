<section class="hello primary">
<h1>Ustaw domyślny język</h1>
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
        
        ?>
</section>