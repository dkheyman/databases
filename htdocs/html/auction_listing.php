<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/login.js"></script>
        <script type="text/javascript" language="javascript">
        	function get_all_active_auctions() {
        		$.post("../php_calls/auctions.php",
                        {
                        	action: "get_all_active_auctions",
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                            	username = data;
                                document.getElementById(auctionlist).innerHTML = data;
                            }
                            else {
                                alert("Unable to find profile!");
                            }
                        })
        	}
        </script>
        <h1> Active Auctions: </h1> <br><br>
    </head>
    <body>
    	<form id= "auctionlist"></form><br>
    </body>
</html>
