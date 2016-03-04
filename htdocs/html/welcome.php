<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" text="text/css" href="../css/login.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        $( document ).ready(function() {
            <?php
                if (!isset($_GET["user"])) {
            ?>
                    grab_user_type();
            <?php
                } else if ($_GET["user"] == 'seller') {
            ?>
                    //hide_other_type("buyer");
            <?php
                } else {
            ?>
                    //hide_other_type("seller");
            <?php
                }
            ?>
            $('#btnLogOut').click(function (){
                logout();
            });
        });
        function grab_user_type() {
            $.post("../php_calls/mail.php",
                {
                    action: "grab_usertype",
                },
                function(data) {
                    console.log(data);
                if (data != 0) {
                    window.location.href = window.location.href + "?user=" + data;
                } else {
                    alert("Something went wrong fetching user information. Try again later");
                }    
            })
        }
        function hide_other_type(usertype) {
            document.getElementById(usertype).style.visibility = "hidden";
        }
        
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
        <div id=
        <a id="btnLogOut" href="#">Sign Out</a>
    </body>
</html>
