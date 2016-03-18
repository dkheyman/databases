<?php
    session_start();
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Bookly- Join</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Optional Bootstrap theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="../css/form.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="../js/login.js"></script>
        <script type="text/javascript" language="javascript">
            function add_user() {
                    $.post("../php_calls/mail.php",
                        {
                            action: "add_user",
                            userID: $("#userID").val(),
                            password: $("#password").val(),
                            email: $("#email").val(),
                            user_type: $('input:radio[name=user_type]:checked').val(),
                        },
                        function(data) {
                            if (data == 1) {
                                window.location = 'http://localhost:8888/html/welcome.php';
                            }
                            else {
                                alert(data);
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
                </button> <a class="navbar-brand" href="#"><img src="../images/logo.jpeg" height="50" width="80" align="middle"></a>
              </div>
        
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li>
                    <a href="register.php">(The Website for True Bookworms)</a>
                  </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a href="register.php">First-Time Users</a>
                  </li>
                  <li>
                    <a href="login.php">Returning Users</a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Register</h2>
            </div>
        </div>
        <form class="replacement" id="replace" action="javascript:add_user()" method="post">
            Username: <input type="text" name="userID" id="userID" required><br>
            Password: <input type="password" name="password" id="password" required><br>
            Email: <input type="text" name="email" id="email" required><br>
            Type:
            <input type="radio" id="user_type" name="user_type" value="Buyer" required />Buyer
            <input type="radio" id="user_type" name="user_type" value="Seller" required />Seller<br>
                    <input class="btn btn-primary btn-large center-block" type="submit" id="change_btn">
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
