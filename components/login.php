<?php //getUtils('login'); 
require_once('./utils/login.php');?>    
    <section class="authform primary no-login">
    <h1>Logowanie</h1>
            <form method="post">
                    <label to="username">Login:</label>
                 <input type="text" name="username" required>
                    <label to="password">Hasło:</label>
                 <input type="password" name="password" required>
                <input type="submit" name="login" value="Zaloguj" class="btn light">
            </form>
    </section>