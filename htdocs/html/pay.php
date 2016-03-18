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
					function verify_payment() {
						document.getElementById('container').innerHTML = "<h2>Payment succeeded! Congratulations</h2><br>Click <a href=&quot; welcome.php &quot;>here</a> to return to your profile";
					}
				</script>
		</head>
		<body>
			<div class="container" id="container">
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
        	<div class="col-md-12"
			 	<h2 class="replacement">You Won! Just a few questions:</h2>
			 </div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3> Billing Information: </h3>
				<form class="replacement">
					Name: <input type="text" name="nameBill" id="nameBill" required><br>
					Address Line 1: <input type="text" name="addr1Bill" id="addr1Bill" required><br>
					Address Line 2: <input type="text" name="addr2Bill" id="addr2Bill" required><br>
					Address Line 3: <input type="text" name="addr3Bill" id="addr3Bill" required><br>
					City: <input type="text" name="cityBill" id="cityBill" required>
					Postcode: <input type="text" name="postcodeBill" id="postcodeBill" required><br>
					Country: <input type="text" name="countryBill" id="countryBill" required><br>
				</form>
			</div>
		</div>
		<div class=row>
			<div class="row">
				<h3> Shipping Information: </h3>
				<form class ="replacement">
					Name: <input type="text" name="nameShip" id="nameShip" required><br>
					Address Line 1: <input type="text" name="addr1Ship" id="addr1Ship" required><br>
					Address Line 2: <input type="text" name="addr2Ship" id="addr2Ship" required><br>
					Address Line 3: <input type="text" name="addr3Ship" id="addr3Ship" required><br>
					City: <input type="text" name="cityShip" id="cityShip" required>
					Postcode: <input type="text" name="postcodeShip" id="postcodeShip" required><br>
					Country: <input type="text" name="countryShip" id="countryShip" required><br>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			 <form id="replace" class="replacement" action="javascript:verify_payment()" method="post">
                    Card Type:

			 		<input type="radio" id="cardType" name="cardType" value="visa"> Visa  <input type="radio" id="cardType" name="cardType" value="mastercard"> Mastercard <br>
			 		<input type="radio" id="cardType" name="cardType" value="americanExpress"> American Express  <input type="radio" id="cardType" name="cardType" value="discover"> Discover <br>
			 		Name: <input type="text" name="nameCard" id="nameCard" required /><br>
			 		Cardnumber: <input type="text" name="cardNum" id="cardNum" required /><br>
			 		CVV: <input type="password" name="cvv" id="cvv" required /><br>
					 <input class="btn btn-primary btn-large center-block" id="add_button" type="submit">
			 </form>
			</div>
		</div>
	</div>
		</body>
</html>
