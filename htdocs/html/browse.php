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
            window.genre = '';
            $(document).ready(function() {
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
                            print_current_auctions(data);
                        else
                            document.getElementById('currAucs').innerHTML = "No auctions found. Check back later!";
                    })
            }

            function update_browser() {
                    var category = document.querySelector('input[name="genre"]:checked').value;
                    window.location.href = "?genre=" + category;
                    get_auction_by_genre(category);
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
                    <a id="btnLogout" href="javascript:logout()">Sign Out</a><!TODO: href>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form id="genre_select">
                </form>
            </div>
            <div class="col-md-8">
                <h2> Active Auctions: </h2>
                <form id="currAucs">
                </form>
            </div>
        </div>
    </div>
   	</body>
</html>
