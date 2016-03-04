<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/login.js"></script>
        <script type="text/javascript" language="javascript">
        	var username;
        	function get_username() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_user",
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                            	username = data;
                                document.getElementById(user).innerHTML = "Welcome " + data + "!";
                            }
                            else {
                                alert("Unable to find profile!");
                            }
                        })
        	}
        	function get_current_aucs() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_current_aucs",
                            userID: username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                document.getElementById(currAucs).innerHTML = data;
                            }
                            else {
                                document.getElementById(currAucs).innerHTML = "No auctions found. Try creating an auction!";
                            }
                        })
        	}
        	function get_past_aucs() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_past_aucs",
                            userID: username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                document.getElementById(pastAucs).innerHTML = data;
                            }
                            else {
                                document.getElementById(pastAucs).innerHTML = "No auctions found. Try creating an auction!";
                            }
                        })
        	}
        	get_username();
        	get_current_aucs();
        	get_past_aucs();
        </script>
        <form id = "user"> Welcome! </form> <br>
    </head>    
    <body>
    	<h1>
    		<br> Current Auctions: <br>
    	</h1>
    	<form id = "currAucs">

    	</form>
    	<h1>
    		<br> Past Auctions: <br>
    	</h1>
    	<form id = "pastAucs">

    	</form>
   	</body>
</html>