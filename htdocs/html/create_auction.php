<?php
		session_start();
?>
<html>
		<head>
				<meta charset="uft-8">
        <title>Bookly- Create Auction</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
				<link rel="stylesheet" type="text/css" href="../css/form.css">
				<link rel="stylesheet" type="text/css" href="../css/textbox.css">
				<script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
				<script type="text/javascript" language="javascript" src="../js/parse.js"></script>
				<script type="text/javascript" language = "javascript">
						window.username = "";
						$(document).ready(function() {
								get_username();
								get_all_books();
						});
						function get_username() {
								$.post("../php_calls/user.php",
									{
											action: "get_user",
									},
									function(data){
										if (data != 0) {
												window.username = data;
										}
                                        else {
                                            document.getElementById('message').innerHTML = "No profile matched!";
                                        }
									})
                        }

						function get_all_books() {
								$.post("../php_calls/auctions.php",
								{
										action: "get_all_books",
								},
								function(data){
									if (data != 0) {
										print_books_with_radio(data);
                                    } else {
                                        document.GetElementById('message').innerHTML = "No books found!";
                                    }
								})
                        }

                        function add_auction() {
                                var isbn = document.getElementById('book').value; 
								$.post("../php_calls/auctions.php", 
										{
												action: "add_auction",
												userID: window.username,
												startPrice: $("#startPrice").val(),
												description: $("#description").val(),
												endTime: $("#endTime").val(),
												isbn: isbn,
										},
								function(data) {
                                    console.log(data);
                                    if (data.length == 32 ) {
                                           window.location.href = "auction.php?auction_id=" + data;
										} else {
											document.getElementById('message').innerHTML = data;
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
        		 <h2> Create Your Auction </h2>
			 	<form id="replace" class="replacement" action="javascript:add_auction()" method="post">
			 		 Books: <div id="book_list"></div><br>
					 Starting Price:<input type="number" step="0.01" name="startPrice" id="startPrice" required><br>
					 End Time:<input type="datetime-local" id="endTime" name="endTime" required><br>
					 Description:<input type="text" name="description" id="description" value="" required><br>
					 <input class="btn btn-primary btn-large center-block" id="add_button" type="submit">
			 </form>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<form id="message">
            	</form>
        	</div>
        </div>
    </div>
   	</body>
</html>
