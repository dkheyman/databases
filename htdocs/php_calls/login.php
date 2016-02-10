<?php
    include 'connect_db.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $con = connect_to_db("bookly");
    $query = "SELECT password FROM Users WHERE username = '$username'";
    $response = mysqli_query($con, $query);
    $resp_pass = $response->fetch_object();
    if ($resp_pass->password === $password)
    {
        echo "Success $resp_pass->password";    
    } else {
        echo "Failure $resp_pass->password";
    }
?>
