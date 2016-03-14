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
            window.userType = '';
            $(document).ready(function() {
                get_username();
                $('#btnLogout').click(function() {
                    logout();
                });
            });

            function run() {
                hide_links();
                get_recommendations();
                get_current_bids();
                get_watches();
                get_past_bids();
            }

            function hide_links() {
                if (window.userType == "Buyer") {
                    $("#review_btn").hide();
                } else {
                    $("#auction_btn").hide();
                }
            }

            function get_username() {
                var params = window.location.search.substring(1);
                window.username = params.split('=')[1];
                console.log(window.username);
                if (window.username == '' || window.username == null) {
                    window.userType = "Buyer";
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
                    window.userType = "Seller";
                    run();
                }
        	}
            
            function get_recommendations() {
                $.post("../php_calls/user.php",
                        {
                            action: "get_recommendations",
                            userID: window.username,
                        },
                        function(data) {
                            console.log(data);
                            if (data != 'No Recommendations') {
                                print_recommended(data);
                            }
                            else {
                                if (data == 'No Recommendations') {
                                    document.getElementById('recommended').innerHTML = "Nothing to recommend to you as of yet!";
                                } else {
                                    document.getElementById('recommended').innerHTML = data;
                                }
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
                            if (data != "No Current Bids") {
                                print_current_bids(data);
                            }
                            else {
                                if (data == "No Current Bids") {
                                    document.getElementById('currBids').innerHTML = "You have not bid on anything yet!";
                                } else {
                                    document.getElementById('currBids').innerHTML = data;
                                }    
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
                            if (data != "No current watches") {
                                print_watches(data);
                            }
                            else {
                                if (data == 'No current watches') {
                                    document.getElementById('watches').innerHTML = "You have not put a watch on anything yet!";
                                } else {
                                    document.getElementById('watches').innerHTML = data;
                                }
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
                            if (data != 'No past bids') {
                                print_past_bids(data);
                            }
                            else {
                                if (data == 'No past bids') {
                                    document.getElementById('pastBids').innerHTML = "You do not have any past bids!";
                                } else {
                                    document.getElementById('pastBids').innerHTML = data;
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
            <a href="#" id="btnLogout">Sign Out</a><br>
        </div>
        <div id="browse">
            <a href="browse.php" id="auction_btn">Auction List</a>
        </div>
        <div id="review">
            <a href="#" id="review_btn">Review Buyer</a>
        </div>
        <h1>
            <br> Recommended for You: <br>
        </h1>
`       <form id="recommended">
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
   	</body>
</html>
