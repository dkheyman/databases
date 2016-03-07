<?php
    session_start();
?>
    <html>
        <head>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script type="text/javascript" language="javascript">

            window.auction = '';
            $(document).ready(function() {
                get_auction_id();
            });

            function get_auction_id() {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_auction_id",
                    },
                    function(data) {
                        if (data != 0) {
                            window.auction = data;
                            get_auction_by_id();
                        }
                        else {
                            echo "Auction ID not found!";
                        }
                    }
                );
            }

            function get_auction_by_id() {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_auction_by_id",
                        auction: window.auction,
                    }
                    function(data) {
                        if (data != 0) {}
                        else {
                            echo "Auction is empty";
                        }
                    }
                );
            }
                            
            </script>
        </head>
        <body>
        </body>
    </html>
