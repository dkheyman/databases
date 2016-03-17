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

            window.auction = '';
            $(document).ready(function() {
                get_auction_id();
                hide_links();
            });

            function get_auction_id() {
                var params = window.location.search.substring(1);
                window.auction = params.split('=')[1];
                if (window.auction == '') {
                    document.getElementById("message").innerHTML = "Auction ID not found!";
                } else {
                    get_auction_by_id();
                    get_bids_by_id();
                }
            }

            function hide_links() {
                $.post("../php_calls/mail.php",
                    {
                        action: "grab_usertype",
                    },
                    function(data) {
                        console.log(data);
                        if (data === 'seller\n') {
                            $("#bid_btn").hide();
                            $("#watch_btn").hide();
                        }
                    })
                $.post("../php_calls/auctions.php",
                    {
                        action: "grab_start_end",
                        auction: window.auction,
                    },
                    function(data) {
                        console.log(data);
                        if (data == 0) {
                            $("#bid_btn").hide();
                            $("#watch_btn").hide();
                        }
                    })
            }

            function get_auction_by_id() {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_auction_by_id",
                        auction: window.auction,
                    },
                    function(data) {
                        console.log(data);
                        if (data != 0) {
                            print_users_auctions(data);
                        }
                        else {
                            document.getElementById("message").innerHTML = "Auction is empty";
                        }
                    }
                )
            }

            function get_bids_by_id() {
                $.post("../php_calls/auctions.php",
                    {
                        action: "get_bids_by_id",
                        auction: window.auction,
                    },
                    function(data) {
                        console.log(data);
                        if (data != "\nNo current bids") {
                            print_bids(data);
                        } else {
                            if (data == "\nNo current bids") {
                                document.getElementById('currBids').innerHTML = "Auction has not been bid on";
                            } else {
                                document.getElementById('currBids').innerHTML = data;
                            }
                        }
                })
            }

            function redirect_to_bid() {
                var link = "bid.php?auction_id=" + window.auction;
                window.location.href = link;
            }

            function redirect_to_watch() {
                var link = "watch.php?auction_id=" + window.auction;
                window.location.href = link;
            }

            function redirect_to_auction_list() {
                var link = "browse.php";
                window.location.href = link;
            }
        
            function logout() {
                $.post("../php_calls/mail.php",
                    {
                        action: "logout",
                    },
                    function(data) {
                        if (data == 1) {
                            window.location.href ="http://localhost:8888/"; 
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
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="javascript:redirect_to_auction_list()" id="auction_btn">Auction List</a><br/>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a id="btnLogout" href="javascript:logout()">Sign Out</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-primary btn-large center-block" href="javascript:redirect_to_watch()" id="watch_btn">Watch Form</a><br/>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-primary btn-large center-block" href="javascript:redirect_to_bid()" id="bid_btn">Bid Form</a><br/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="user_auctions"></form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Bids</h2>    
                    <form id="currBids"></form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="message"></form>
                </div>
            </div>
            </div>
        </body>

            </div>
        </body>
    </html>
