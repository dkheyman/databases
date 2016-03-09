<?php
session_start();
?>

<html>
    <head>
        <link rel="stylesheet" text="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript">

        window.username = '';
        window.auction = '';

        $(document).ready(function() {
            get_username();
            get_auction_id();
        });

        function get_auction_id() {
            var params = window.location.search.substring(1);
            window.auction = params.split('=')[1];
            if (window.auction == '') {
                document.getElementById('message').innerHTML = "Auction ID not found!";
            } 
        }

        function get_username() {
            $.post("../php_calls/user.php",
                {
                    action: "get_user",
                },
                function(data) {
                    if (data != 0) {
                        window.username = data;
                    }
                    else {
                        alert("Unable to find profile!");
                    }
                })
        }

        function submit_bid() {
            $.post("../php_calls/bid.php",
                {
                    action: "add_bid",
                    buyerID: window.username,
                    auctionID: window.auction,
                    value: $("#value").val(),
                    password: $("#password").val(),
                },
                function(data) {
                    if (data == 1) {
                        document.getElementById('message').innerHTML = "Bid added!";
                    } else {
                        document.getElementById('message').innerHTML = data;
                        $("#replace").trigger("reset");
                    }
                })
        }
        </script>
    </head>
    <body>
        <h1 class="replacement">Please Fill Out Your Bid</h1>
        <form id="replace" class="replacement" action="javascript:submit_bid()" method="post">
            Your Password: <input type="password" name="password" id="password" required><br><br>
            Bid Value: <input type="number" step="0.01" name="value" id="value" required><br><br>
            <input id="submit_btn" type="submit">
        </form>
        <form id="message"></form>
    </body>
</html> 
