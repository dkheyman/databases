<?php
session_start();
?>

<html>
    <head>
        <meta charset="uft-8">
        <title>Bookly- Bid</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="../css/table.css">
        <link rel="stylesheet" type="text/css" href="../css/stars.css">

        <link rel="stylesheet" text="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" language="javascript">

        window.username = '';
        window.auction = '';

        $(document).ready(function() {
            get_username();
            get_auction_id();
        });

        function get_auction_id() {
            var params = window.location.search.substring(1);
            window.auction = params.split('=')[1];
            if (window.auction == '') {
                document.getElementById('message').innerHTML = "Auction ID not found!";
            } 
        }

        function get_username() {
            $.post("../php_calls/user.php",
                {
                    action: "get_user",
                },
                function(data) {
                    if (data != 0) {
                        window.username = data;
                    }
                    else {
                        alert("Unable to find profile!");
                    }
                })
        }

        function submit_bid() {
            $.post("../php_calls/bid_watch.php",
                {
                    action: "add_bid",
                    buyerID: window.username,
                    auctionID: window.auction,
                    value: $("#value").val(),
                    password: $("#password").val(),
                },
                function(data) {
                    if (data == 1) {
                        document.getElementById('message').innerHTML = "Bid added!";
                        window.location.href = "auction.php?auction_id=" + window.auction;
                    } else {
                        document.getElementById('message').innerHTML = data;
                        $("#replace").trigger("reset");
                    }
                })
        }
        </script>
    </head>
    <body>
        <div class="container">
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
            <div class="col-md-12>"
                <h2>Please Fill Out Your Bid</h2>
                <form id="replace" class="replacement" action="javascript:submit_bid()" method="post">
                    Your Password: <input type="password" name="password" id="password" required><br><br>
                    Bid Value: <input type="number" step="0.01" name="value" id="value" required><br><br>
                    <input class="btn btn-primary btn-large center-block" id="submit_btn" type="submit">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"
                <form id="message"></form>
            </div>
        </div>
    </body>
</html> 
