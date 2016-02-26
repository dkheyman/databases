<?php
session_start();
echo session_id();
?>

<html>
    <head>
        <link rel="stylesheet" text="text/css" href="../css/login.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        function logout() {
            $.post("../php_calls/mail.php",
                {
                    action: "logout",
                },
        function(data) {
            if (data == 1) {
                window.location.href ="http://localhost:8888/"; 
            }
        })
        }
    </script>
    </head>
    <body>
        <p> Welcome! </p>
        <a href="#" onClick="javascript:logout();">Sign Out</a>
    </body>
</html>
