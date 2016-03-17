<?php
session_start();
?>
<html>
    <head>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/login.js"></script>
    <script type="text/javascript" language="javascript">
        $( document ).ready(function() {
            <?php
                if (!isset($_GET["user"])) {
            ?>
                    grab_user_type();
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
                    if (data === 'buyer\n') {
                        window.location.href = "/html/buyer_profile.php";
                    } else if (data == 'seller\n') {
                        window.location.href = "/html/seller_profile.php";
                    } else {
                        var temp = data.length;
                        alert(temp);
                    }    
                })
        }
    
    </script>
    </head>
    <body>
    </body>
</html>
