<?php
		session_start();
?>
<html>
		<head>
				<meta charset="uft-8">
        <title>Bookly- Add Book</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
				<link rel="stylesheet" type="text/css" href="../css/form.css">
				<link rel="stylesheet" type="text/css" href="../css/centerheader.css">
				<script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <script type="text/javascript" language = "javascript">
				    function add_book() {
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
                                        console.log(data);
                                        if (data == 1) {
                                            window.location.href = "create_auction.php";
										} else {
                                            document.getElementById('message').innerHTML = data;
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
			<div class="col-md-12">
			 <form id="replace" class="replacement" action="javascript:add_book()" method="post">
			 		 Title:<input type='text' name='title' id='title' value="" required/>
			 		 ISBN:<input type='text' name='isbn' id='isbn' value="" required/>
			 		 Author's First Name:<input type='text' name='aFirst' id='aFirst' value=""/>
			 		 Author's Surname:<input type='text' name='aLast' id='aLast' value="" required/>
			 		 Genre: <input type='text' name='genre' id='genre' value="" required/>
			 		 Publisher: <input type='text' name='publisher' id='publisher' value=""/>
			 		 Language: <input type='text' name='language' id='language' value="English" required/>
			 		 Date: <input type="date" id="date" name="date"><br>
			 		 Condition: <select id="condition" name="condition">
			 		 	<option value="New"> New </option>
			 		 	<option value="Used:Excellent"> Used:Excellent </option>
			 		 	<option value="Used:Good"> Used:Good </option>
			 		 	<option value="Used:Fair"> Used:Fair </option>
			 		 	<option value="Used:Poor"> Used:Poor </option>
			 		 </select>
			 		 Binding: <select id="binding" name="condition">
			 		 	<option value="Hardcover"> Hardcover </option>
			 		 	<option value="Softcover"> Softcover </option>
			 		 	<option value="Leather"> Leather </option>
			 		 	<option value="None"> None </option>
			 		 </select><br>
					 <input class="btn btn-primary btn-large center-block" id="add_button" type="submit">
			 </form>
			</div>
		</div>
    </div>
    <div class="row">
        <form id="message">
        </form>
    </div>
		</body>
</html>
