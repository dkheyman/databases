<?php
session_start();
?>
<html>
    <head>
        <meta charset="uft-8">
        <title>Bookly- Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../js/parse.js"></script>
       <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/stars.css">

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
                get_rating();
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
                $.post("../php_calls/user.php",
                            {
                                action: "get_user",
                            },
                            function(data) {
                                if (data != 0 && ((window.username == "" || window.username == null) || data == window.username)) {
                                    window.username = data;
                                    window.userType = "Buyer";
                                    document.getElementById('user').innerHTML = "Welcome " + window.username + "!";
                                    run();
                                } else if (window.username != "" && window.user != null) {
                                    window.userType = "Seller";
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
                            $('#errors').show();
                        }
                })
            }
            function review_user() {
                $.post("../php_calls/user.php",
                    {
                        action: "review",
                        content: $("#review_content").val(),
                        reviewee: window.username,
                        rating: $("input:radio[name='rating']:checked").val(),
                    },
                    function(data) {
                        if (data != 1) {
                            document.getElementById('alert_contents').innerHTML = data;
                            $('#alert').show();
                        } else {
                            $('#modal-container').close();
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
                <div class="col-md-12" id="browse">
                    <a data-target="browse.php" id="auction_btn" class="btn btn-primary btn-large">Auction List</a>
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
                            <div id="alert" class="alert alert-danger alert-dismissable collapse" aria-hidden="true">
                                <h4>
                                Alert!
                                </h4><div id="alert_contents"></div>
                            </div>
                        </div>
                        <div class="modal-footer">   
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button> 
                            <button type="button" class="btn btn-primary" onClick="javascript:review_user()" data-dismiss="modal">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="errors" class="alert alert-danger alert-dismissable collapse" aria-hidden="false">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <h4>Alert!</h4>
                <form id="messages"></form>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h1>
                    <br> Recommended for You: <br>
                    </h1>
    `               <form id="recommended">
                    </form>
                </div>
                <div class="col-md-6">
                    <h1>
                    <br> Watches: <br>
                    </h1>
                    <form id="watches">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h1>
                    <br> Current Bids: <br>
                    </h1>
                    <form id="currBids">
                    </form>
                </div>
                <div class="col-md-6">
                    <h1>
                    <br> Past Bids: <br>
                    </h1>
                    <form id="pastBids">
                    </form>
                </div>
            </div>
        </div>
   	</body>
</html>
