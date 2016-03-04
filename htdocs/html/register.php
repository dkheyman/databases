<?php
    session_start();
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/login.js"></script>
        <script type="text/javascript" language="javascript">
            function add_user() {
                if (test_password($("#password").val())) {
                    $.post("../php_calls/mail.php",
                        {
                            action: "add_user",
                            userID: $("#userID").val(),
                            password: $("#password").val(),
                            email: $("#email").val(),
                            user_type: $('input:radio[name=user_type]:checked').val(),
                        },
                        function(data) {
                            if (data == 1) {
                                window.location = 'http://localhost:8888/html/welcome.php';
                            }
                            else {
                                alert(data);
                            }
                        })
                } else {
                    return;
                }
            }
        </script>
    </head>    
    <body>
        <h1 class="replacement">Register User</h1>
        <form class="replacement" id="replace" action="javascript:add_user()" method="post">
            Username: <input type="text" name="userID" id="userID" required><br>
            Password: <input type="password" name="password" id="password" required><br>
            Email: <input type="text" name="email" id="email" required><br>
            Type:
            <input type="radio" id="user_type" name="user_type" value="Buyer" required />Buyer
            <input type="radio" id="user_type" name="user_type" value="Seller" required />Seller<br>
                    <input type="submit" id="change_btn">
        </form>
    </body>
</html>
