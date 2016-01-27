<?php echo "Welcome to Book.ly! Please sign in or register as a first-time user"; ?>
<html>
    <body>
        <form action="php_calls/insert.php" method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            Email: <input type="text" name="email"><br>
            Type: <input type="radio" name="type" value="Buyer">Buyer</input>
                  <input type="radio" name="type" value="Seller">Seller<br>
                    <input type="submit">
        </form>
    </body>
</html>
