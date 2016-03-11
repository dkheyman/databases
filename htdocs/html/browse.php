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
            $(document).ready(function() {
                 get_genre();
                 get_available_genres();
            });

            function get_genre() {
                var params = window.location.search.substring(1);
                window.genre = params.split('=')[1];
                if (window.genre == '') {
                    document.getElementById('message').innerHTML = "Genre not found";
                } else {
                    get_auction_by_genre(window.genre);
        	    }
            }

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
                                alert("No genre information!")
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
                            print_current_auctions(data);
                        else
                            document.getElementById('auctions').innerHTML = "No auctions found. Check back later!";
                    })
        	}

        </script>
    </head>    
    <body>
    	<h1>
    		<br> Active Auctions: <br>
    	</h1>
    	<form id="currAucs">
    	</form>
        <form id="genre_select">
        </form>
   	</body>
</html>
