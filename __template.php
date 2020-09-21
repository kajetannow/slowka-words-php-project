<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?php echo config('page_name') ?></title>
    <link href="https://fonts.googleapis.com/css?family=Blinker:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=<?php getStyle('style')?>>
    <?php getScript('handleAlert')?>
</head>
<body>
<header>
        <h1 class="title"><a href="<?php echo siteUrl()?>"><?php echo config('page_name') ?></a></h1>
        <div class="login-panel">
        <?php 
        if((empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true')){ ?>
        <a href="<?php echo siteUrl()?>/register" class="btn light">Zarejestruj</a>
        <a href="<?php echo siteUrl()?>/login" class="btn dark">Zaloguj</a>
        <?php }else if(isset($_SESSION['user'])){ ?>
            <p class="hide-mobile">Zalogowano jako: <em><?php echo $_SESSION['user'] ?></em></p>
            <?php
            if(in_array('admin',$_SESSION['groups']) && !strstr($_SERVER['REQUEST_URI'],'admin')){
                echo '<a href="',siteUrl(),'/admin" class="btn light">Panel administratora</a></li>';    
            } ?>
            <a href="<?php echo siteUrl()?>/logout" class="btn dark">Wyloguj</a>
            <?php 
           } ?>
        </div>
</header>
<?php
if(!empty($_SESSION["authenticated"])){
    getComponent('menu');
    echo "<div class=\"container\">";
}
else
    echo "<div class=\"container container-no-login\">";

getComponent(checkPermission());

?>
</div>
<footer>
2019-<?php echo date('Y'); ?> &copy; <?php echo config('author') ?> // Wersja: <em><?php echo config('version') ?></em>
</footer>
</body>
</html>
