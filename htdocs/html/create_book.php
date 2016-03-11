<?php
		session_start();
?>
<html>
		<head>
				<link rel="stylesheet" type="text/css" href="../css/form.css">
				<script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
				<script type="text/javascript" language = "javascript">
					add_book() {
						$.post("../php_calls/auctions.php", 
								{
										action: "add_book",
										title: $("#title").val(),
										isbn: $("#isbn").val(),
										aFirst: $("#aFirst").val(),
										aLast: $("#aLast").val(),
										genre: $("#genre").val(),
										publisher: $("#publisher").val(),
										language: $("#language").val(),
										date: $("#date").val(),
										condition: $("#condition option:selected").val(),
										binding: $("#binding option:selected").val(),
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
			 <h1>Add Book to Database</h>
			 <form id="addImage" class="replacement" action="javascript:add_book()" enctype="multipart/form-data" method="post">
			 		Submit a Photo: <input type="file" name="bookimage" id="bookimage">
			 		<input id="add_image" type="submit">
			 </form>
			 <h1 class="replacement"> </h1>
			 <form id="replace" class="replacement" action="javascript:add_book()" method="post">
			 		 Title:<input type='text' name='title' id='title' value="" required/>
			 		 ISBN:<input type='text' name='isbn' id='isbn' value="" required/>
			 		 Author's First Name:<input type='text' name='aFirst' id='aFirst' value=""/>
			 		 Author's Surname:<input type='text' name='aLast' id='aLast' value="" required/>
			 		 Genre: <input type='text' name='genre' id='genre' value="" required/>
			 		 Publisher: <input type='text' name='publisher' id='publisher' value=""/>
			 		 Language: <input type='text' name='language' id='language' value="English" required/>
			 		 Date: <input type="date" name="date">
			 		 Condition: <select id="condition" name="condition">
			 		 	<option value="New"> New </option>
			 		 	<option value="Used:Excellent"> Used:Excellent </option>
			 		 	<option value="Used:Good"> Used:Good </option>
			 		 	<option value="Used:Fair"> Used:Fair </option>
			 		 	<option value="Used:Poor"> Used:Poor </option>
			 		 </select>
			 		 Condition: <select id="binding" name="condition">
			 		 	<option value="Hardcover"> Hardcover </option>
			 		 	<option value="Softcover"> Softcover </option>
			 		 	<option value="Leather"> Leather </option>
			 		 	<option value="None"> None </option>
			 		 </select><br>
					 <input id="add_button" type="submit">
			 </form>
		</body>
</html>