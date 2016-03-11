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
										else {}
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
									} else {}
								})
						}
						function add_auction() {
								$.post("../php_calls/auctions.php", 
										{
												action: "add_auction",
												userID: window.username,
												startPrice: $("#startPrice").val();
												description: $("#description").val();
												endTime: $("endTime").val();
												isbn: $('input:radio[name=book_radio]:checked').val(),
										},
								function(data) {
										if (data == 1) {
										} else {
											console.log("An error occurred");
										}
								})
						}
				</script>
	 </head>
	 <body>
			 <h1>Create Auction</h>
			 <h1 class="replacement"> </h1>
			 <form id="replace" class="replacement" action="javascript:add_auction()" method="post">
			 		 Books: <div id="book_list"></div><br>
					 Starting Price:<input type="number" step="0.01" name="startPrice" id="startPrice" required><br>
					 End Time:<input type="datetime-local" name="endTime" required>
					 Description:<input type='text' name='description' id='my-text-box' value="" required/>
					 <input id="add_button" type="submit">
			 </form>
	 </body>
</html>
