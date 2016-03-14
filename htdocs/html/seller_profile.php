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
                var params = window.location.search.substring(1);
                window.username = params.split('=')[1];
                console.log(window.username);
                if (window.username == "" || window.username == null) {
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
                        })
                } else {
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
                            if (data != "No current auctions") {
                                print_current_auctions(data);
                            }
                            else {
                                if (data == "No current auctions") {
                                    document.getElementById('currAucs').innerHTML = "No auctions found. Try creating an auction!";
                                } else {
                                    document.getElementById('currAucs').innerHTML = data;
                                }
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
                            if (data != "No past auctions") {
                                print_past_auctions(data);
                            }
                            else {
                                if (data == "No past auctions") {
                                    document.getElementById('pastAucs').innerHTML = "No auctions found. Try creating an auction!";
                                } else {
                                    document.getElementById('pastAucs').innerHTML = data;
                                }
                            }
                        })
            }

            function logout() {
                $.post("../php_calls/mail.php",
                    {
                        action: "logout",
                    },
                    function(data) {
                        console.log(data);
                        if (data == 1) {
                            window.location.href = "http://localhost:8888/";
                        } else {
                            document.getElementById('messages').innerHTML = data;
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
        <div id="create">
            <a href="create_auction.php" id="create_btn">Create New Auction</a>
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
