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
        <link rel="stylesheet" type="text/css" href="../css/stars.css">
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
                hide_links();
                get_rating();
                get_current_aucs();
                get_past_aucs();
            }
            
            function hide_links() {
                if (window.userType == "Seller") {
                    $("#review_btn").hide();
                } else {
                    $("#create_btn").hide();
                }
            }
            
            function get_username() {
                var params = window.location.search.substring(1);
                window.username = params.split('=')[1];
                console.log(window.username);
                $.post("../php_calls/user.php",
                        {
                            action: "get_user",
                        },
                        function(data) {
                            if (data != 0 && ((window.username == "" || window.username == null) || data ==  window.username) {
                            	window.username = data;
                                window.userType = "Seller";
                                document.getElementById('user').innerHTML = "Welcome " + window.username + "!";
                                run();
                            } else if (window.username != "" && window.user != null) {
                                window.userType = "Buyer";
                                run();
                            }
                            else {
                                alert("Unable to find profile!");
                            }
                        })
        	}
            function get_rating() {
                $.post("../php_calls/user.php",
                        {
                            action: "get_user_rating",
                            userID: window.username,
                        },
                        function(data) {
                            if (data != 0 && data <= 5) {
                                var rating = data;
                                document.getElementById('star_rating').innerHTML = username + "<br>";
                                for (var i=0; i<5;i++) {
                                    if (rating > 0) {
                                        rating--;
                                        document.getElementById('star_rating').innerHTML = document.getElementById('star_rating').innerHTML + "★";  
                                    }  else {
                                        document.getElementById('star_rating').innerHTML = document.getElementById('star_rating').innerHTML + "☆";
                                    }
                                }
                            }
                        })
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
            function review_user() {
                $.post("../php_calls/user.php",
                    {
                        action: "review",
                        content: $("#review_content").val(),
                        reviewee: window.username,
                        rating: $("#rating").val(),
                    },
                    function(data) {
                        if (data != 1) {
                            document.getElementById('alert_contents').innerHTML = data;
                            document.getElementById('alert').setAttribute("aria-hidden", "false");
                        }
                    })
            }
        </script>
    </head>    
    <body>
        <div class="container-fluid">
            <div class="row">
          <div class="col-md-12">
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button> <a class="navbar-brand" href="welcome.php"><img src="../images/logo.jpeg" height="50" width="80" align="middle"></a>
              </div>
        
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li>
                    <a href="welcome.php">(The Website for True Bookworms)</a>
                  </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a id="btnLogout" href="#">Sign Out</a><!TODO: href>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="user"> Welcome! </form> <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 id="star_rating"></h2>
                </div>
            </div>
            <div class="row">
                <div class ="col-md-12" id="create">
                    <a class="btn btn-primary btn-large center-block" href="create_auction.php" id="create_btn">Create New Auction</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="review">
                    <a href="#modal-container" role="button" class="btn" data-toggle="modal" id="review_btn">Review Seller</a>
                </div>
            </div>
            <div class="modal fade" id="modal-container" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">                       
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Review User
                            </h4>
                        </div>
                        <div class="modal-body">
                            <textarea name="review_content" id="review_content" rows=5 cols=30 >
                            </textarea><br>
                            Rating:
                            <span class="starRating">
                                <input id="rating5" type="radio" name="rating" value="5">
                                <label for="rating5">5</label>
                                <input id="rating4" type="radio" name="rating" value="4">
                                <label for="rating4">4</label>
                                <input id="rating3" type="radio" name="rating" value="3" checked>
                                <label for="rating3">3</label>
                                <input id="rating2" type="radio" name="rating" value="2">
                                <label for="rating2">2</label>
                                <input id="rating1" type="radio" name="rating" value="1">
                                <label for="rating1">1</label>
                            </span>
                            <div id="alert" class="alert alert-danger alert-dismissable" aria-hidden="true">
                                <h4>
                                Alert!
                                </h4><div id="alert_contents"></div>
                            </div>
                        </div>
                        <div class="modal-footer">   
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button> 
                            <button type="button" class="btn btn-primary" action="javascript:review_user()" data-dismiss="modal">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h1>
    		          <br> Current Auctions: <br>
    	           </h1>
    	           <form id="currAucs">

    	           </form>
                </div>
                <div class="col-md-6">
    	           <h1>
    		          <br> Past Auctions: <br>
    	           </h1>
    	           <form id="pastAucs">
    	           </form>
                </div>
            </div>
        </div>
   	</body>
</html>
