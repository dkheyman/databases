<?php
session_start();
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../js/parse.js"></script>
        <script type="text/javascript" language="javascript">

            window.username = '';
            window.userType = '';
            $(document).ready(function() {
                get_username();
                $('#btnLogout').click(function() {
                    logout();
                });
            });

            function run() {
                get_current_aucs();
                get_past_aucs();
            }

            function get_username() {
                console.log(window.location.search.substring(1));
                var params = window.location.search.substring(1);
                window.auction = params.split('=')[1];
                console.log(window.auction);
                if (window.auction == "" || window.auction == null) {
                    window.userType = "Seller";
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
                  })}
                else {
                  window.userType = "Buyer";
                  run();
                }
        	}
        	function get_current_aucs() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_current_aucs",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (JSON.parse(data)) {
                                print_current_auctions(data);
                            }
                            else {
                                document.getElementById('currAucs').innerHTML = "No auctions found. Try creating an auction!";
                            }
                        })
        	}
        	function get_past_aucs() {
        		$.post("../php_calls/user.php",
                        {
                            action: "get_past_aucs",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (JSON.parse(data)) {
                                print_past_auctions(data);
                            }
                            else {
                                document.getElementById('pastAucs').innerHTML = "No auctions found. Try creating an auction!";
                            }
                        })
            }

            function logout() {
                $.post("../php_calls/mail.php",
                    {
                        action: "logout",
                    },
                    function(data) {
                        if (data == 1) {
                            window.location.href = "http://localhost:8888/";
                        }
                })
            }

        </script>
    </head>    
    <body>
        <form id="user"> Welcome! </form> <br>
        <div id="logout">
            <a href="#" id="btnLogout">Sign Out</a>
        </div>
        <h1>
    		<br> Current Auctions: <br>
    	</h1>
    	<form id="currAucs">

    	</form>
    	<h1>
    		<br> Past Auctions: <br>
    	</h1>
    	<form id="pastAucs">
    	</form>
   	</body>
</html>
