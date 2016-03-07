<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript">

            window.username = '';
            $(document).ready(function() {
                 get_username();
            });

            function run() {
                get_current_bids();
                get_watches();
                get_past_bids();
            }

            function get_username() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_user",
                        },
                        function(data) {
                            if (data != 0) {
                                window.username = data;
                                document.getElementById('user').innerHTML = "Welcome " + window.username + "!";
                                run();
                            }
                            else {
                                alert("Unable to find profile!");
                            }
                        })
        	}
            
            function get_current_bids() {
                $.post("../php_calls/user.php",
                        {
                            action: "get_current_bids",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                document.getElementById('currBids').innerHTML = data;
                            }
                            else {
                                document.getElementById('currBids').innerHTML = "No bids found. Try bidding on an item!";
                            }
                        })
        	}
        	function get_watches() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_watches",
                            userID: username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                document.getElementById('watches').innerHTML = data;
                            }
                            else {
                                document.getElementById('watches').innerHTML = "No watches found. Add a watch to an auction to keep an eye on some choice items!";
                            }
                        })
        	}
        	function get_past_bids() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_past_bids",
                            userID: username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                document.getElementById('pastBids').innerHTML = data;
                            }
                            else {
                                document.getElementById('pastBids').innerHTML = "No bids found. Try bidding on an item!";
                            }
                        })
        	}


        </script>
    </head>    
    <body>
        <form id="user"> Welcome! </form> <br>
    	<h1>
    		<br> Current Bids: <br>
    	</h1>
    	<form id="currBids">

    	</form>
    	<h1>
    		<br> Watches: <br>
    	</h1>
		<form id="watches" >

    	</form>
    	<h1>
    		<br> Past Bids: <br>
    	</h1>
    	<form id="pastBids">
    	</form>
   	</body>
</html>
