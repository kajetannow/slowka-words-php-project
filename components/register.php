<?php //getUtils('register'); 
require_once('./utils/register.php');?>   
    <section class="authform primary no-login">
        <h1>Rejestracja</h1>
            <form method="post">
                
                    <label to="username">Login:</label>
                 <input type="text" name="username" required>
                
                
                    <label to="password">Hasło:</label>
                 <input type="password" name="password" required>
                
                
                    <label to="password_check">Powtórz hasło:</label>
                 <input type="password" name="password_check" required>
                
                
                    <label to="email">Email:</label>
                 <input type="text" name="email" required>
                
                <input type="submit" name="register" value="Zarejestruj się" class="btn light">
            </form>
    </section>