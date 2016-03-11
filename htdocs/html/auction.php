<?php
    session_start();
?>
    <html>
        <head>
            <link rel="stylesheet" type="text/css" href="../css/table.css">
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script type="text/javascript" language="javascript" src="../js/parse.js"></script>
            <script type="text/javascript" language="javascript">

            window.auction = '';
                $(document).ready(function() {
                get_auction_id();
            });

            function get_auction_id() {
                console.log(window.location.search.substring(1));
                var params = window.location.search.substring(1);
                
                window.auction = params.split('=')[1];
                if (window.auction == '') {
                    document.getElementById("message").innerHTML = "Auction ID not found!";
                } else {
                    get_auction_by_id();
                }
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
                            
            </script>
        </head>
        <body>
            <a href="javascript:redirect_to_auction_list()" id="auction_btn">Auction List</a><br/>
            <a href="javascript:redirect_to_bid()" id="bid_btn">Bid Form</a><br/>
            <a href="javascript:redirect_to_watch()" id="watch_btn">Watch Form</a><br/>
            <form id="user_auctions"></form>
            <form id="message"></form>
        </body>
    </html>
