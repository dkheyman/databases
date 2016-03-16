<?php
session_start();
?>
<html>
    <head>
        <meta charset="uft-8">
        <title>Bookly- Browse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../js/parse.js"></script>
        <script type="text/javascript" language="javascript">

            window.username = '';
            
            $(document).ready(function() {
                var params = window.location.search.substring(1);
                window.genre = params.split('=')[1];
                if (window.genre) {
                    get_auction_by_genre(window.genre);
                } else {
                    get_auction_by_genre();
                } 
                get_available_genres();
                $("#LogOutBtn").click(function() {
                    logout();
                })
            });

            function get_available_genres() {
                $.post("../php_calls/auctions.php",
                        {
                            action: "get_available_genres",
                        },
                        function(data) {
                            console.log(data);
                            if (data != 0) {
                                print_genres(data);
                            } else {
                                document.getElementById('genre_select').innerHTML = "No genres found!";
                            }
                        })
            }
            
            function get_auction_by_genre(category) {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_active_auctions",
                        genre: category,
                    },
                    function(data) {
                        console.log(data);
                        if (data != 0)
                            print_current_auctions(data, 'with_id');
                        else
                            document.getElementById('currAucs').innerHTML = "No auctions found. Check back later!";
                    })
            }

            function update_browser() {
                    var category = document.querySelector('input[name="genre"]:checked').value;
                    window.location.href = "?genre=" + category;
            }
            
             function logout() {
                $.post("../php_calls/mail.php",
                    {
                        action: "logout",
                    },
                    function(data) {
                        if (data == 1) {
                            window.location.href = "http://localhost:8888/";
                        } else {
                            alert("Logout failed");
                        }
                    })
            }

        </script>
    </head>    
    <body>
        <a href="javascript:logout()" id="logOutBtn">Sign Out</a>
        <h1>
    		<br> Active Auctions: <br>
        </h1>
    	<div id="currAucs">
    	</div>
        <div id="genre_select">
        </div>
   	</body>
</html>
