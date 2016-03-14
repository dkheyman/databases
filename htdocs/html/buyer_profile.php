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
            window.viewerRole = '';
            $(document).ready(function() {
                get_username();
                $('#btnLogout').click(function() {
                    logout();
                });
            });

            function run() {
                get_recommendations();
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
            function get_recommendations() {
                $.post"../php_calls/user.php",
                        {
                            action: "get_recommendations",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (JSON.parse(data)) {
                                print_recommended(data);
                            }
                            else {
                                document.getElementById('recommended').innerHTML = data;
                            }
                        })
            }
            
            function get_current_bids() {
                console.log(window.username);
                $.post("../php_calls/user.php",
                        {
                            action: "get_current_bids",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (JSON.parse(data)) {
                                print_current_bids(data);
                            }
                            else {
                                document.getElementById('currBids').innerHTML = data;
                            }
                        })
        	}
            function get_watches() {
                console.log(window.username);
        		$.post("../php_calls/user.php",
                        {
                            action: "get_watches",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (JSON.parse(data)) {
                                print_watches(data);
                            }
                            else {
                                document.getElementById('watches').innerHTML = data;
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
                            if (JSON.parse(data)) {
                                print_past_bids(data);
                            }
                            else {
                                document.getElementById('pastBids').innerHTML = data;
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
        <h1>
            <br> Recommended for You: <br>
        </h1>
        <form id="recommended">
        </form>
    	<h1>
    		<br> Current Bids: <br>
    	</h1>
    	<form id="currBids">
    	</form>
    	<h1>
    		<br> Watches: <br>
    	</h1>
		<form id="watches">
    	</form>
    	<h1>
    		<br> Past Bids: <br>
    	</h1>
    	<form id="pastBids">
        </form>
        <form id="messages">
        </form>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   	</body>
</html>
