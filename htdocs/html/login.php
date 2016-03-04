<?php
    session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language = "javascript">
            function login_user() {
                $.post("../php_calls/mail.php", 
                    {
                        action: "login_user",
                        userID: $("#userID").val(),
                        password: $("#password").val(),
                    },
                function(data) {
                    console.log(data);
                    if (data == 1) {
                        window.location.href = 'http://localhost:8888/html/welcome.php';
                    }
                    else {
                        alert(data);
                        $("#replace").trigger("reset");
                    }
                })
            }
        </script>
   </head>
   <body>
       <h1 class="replacement">Welcome to Book.ly! Please sign in</title>
       <form id="replace" class="replacement" action="javascript:login_user()" method="post">
           userID: <input type="text" name="userID" id="userID" required><br>
           Password: <input type="password" name="password" id="password" required><br>
           <input id="login_btn" type="submit">
       </form>
       <a href="reset.html">Forgot password?</a><br/>
       <a href="change.html">Change password?</a>
   </body>
</html>
