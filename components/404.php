<section class="hello primary">
        <h1>
           Błąd 404
        </h1>
        <h3>Hola, hola<?php echo " $_SESSION[user]"?>!</h3>
        <p>Nie znaleziono szukanej przez Ciebie strony - "<?php echo basename($_SERVER['REQUEST_URI']);?>"</p>
        <p>Ale za to Mika znalazła Ciebie</p>
        <img class="word-img" src="<?php echo siteUrl()?>/images/404.jpg">
</section>