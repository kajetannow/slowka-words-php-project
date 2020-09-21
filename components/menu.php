<button class="btn dark open-menu">menu</button>
<nav class="primary">
        <button class="btn light close-menu">X</button>
        <ul>
        <?php
        if(strstr($_SERVER['REQUEST_URI'],'admin'))
        $el = config("admin_menu");
        else
        $el = config("menu");
        foreach($el as $href => $name){
        //str_replace('page=', '', $_SERVER['QUERY_STRING']) == $href ? ' active' : '';
        echo "<li class=\"block light\"><a href=\"",siteUrl(),"/$href\">$name</a></li>";
        }
        ?>
        </ul>
</nav>
<?php 
getScript('mobilemenu');
?>