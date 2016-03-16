<?php
		session_start();
?>
<html>
		<head>
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
                                var isbn = document.getElementById('book_name').value;
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
            <form id="message">
            </form>
			 <h1 class="replacement"> Create Your Auction </h1>
			 <form id="replace" class="replacement" action="javascript:add_auction()" method="post">
			 		 Books: <div id="book_list"></div><br>
					 Starting Price:<input type="number" step="0.01" name="startPrice" id="startPrice" required><br>
					 End Time:<input type="datetime-local" id="endTime" name="endTime" required><br>
					 Description:<input type="text" name="description" id="description" value="" required><br>
					 <input id="add_button" type="submit">
			 </form>
	 </body>
</html>
