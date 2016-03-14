<?php
    session_start();
?>
    <html>
        <head>
        <meta charset="uft-8">
        <title>Bookly- Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../js/parse.js"></script>
        <script type="text/javascript" language="javascript">

            window.auction = '';
            $(document).ready(function() {
                hide_links();
                get_auction_id();
            });

            function get_auction_id() {
                var params = window.location.search.substring(1);
                window.auction = params.split('=')[1];
                if (window.auction == '') {
                    document.getElementById("message").innerHTML = "Auction ID not found!";
                } else {
                    get_auction_by_id();
                }
            }

            function hide_links() {
                $.post("../php_calls/mail.php",
                    {
                        action: "grab_usertype",
                    },
                    function(data) {
                        console.log(data);
                        if (data === 'seller\n') {
                            $("#bid_btn").hide();
                            $("#watch_btn").hide();
                        }
                    })
            }

            function get_auction_by_id() {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_auction_by_id",
                        auction: window.auction,
                    },
                    function(data) {
                        console.log(data);
                        if (data != 0) {
                            print_users_auctions(data);
                        }
                        else {
                            document.getElementById("message").innerHTML = "Auction is empty";
                        }
                    }
                )
            }

            function redirect_to_bid() {
                var link = "bid.php?auction_id=" + window.auction;
                window.location.href = link;
            }

            function redirect_to_watch() {
                var link = "watch.php?auction_id=" + window.auction;
                window.location.href = link;
            }

            function redirect_to_auction_list() {
                var link = "browse.php";
                window.location.href = link;
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
            <div id="links">
                <a href="javascript:logout()" id="logOutBtn">Sign Out</a><br/>
                <a href="javascript:redirect_to_auction_list()" id="auction_btn">Auction List</a><br/>
                <a href="javascript:redirect_to_bid()" id="bid_btn">Bid Form</a><br/>
                <a href="javascript:redirect_to_watch()" id="watch_btn">Watch Form</a><br/>
            </div>
            <div id="forms">
                <form id="user_auctions"></form>
                <form id="message"></form> 
            </div>
        </body>
    </html>
