<?php
$database = "bookly";
$username = $_POST['username'];
$password = $_POST['password'];

$con = mysqli_connect('localhost', 'root', 'root', 'bookly');
if (!$con) {
    echo mysqli_error($con);
    die('Could not connect to database: ' . mysqli_error($con));
}
mysqli_select_db($con, "$database");

$query = "SELECT password FROM Users WHERE username = '$username'";
$response = mysqli_query($con, $query);
$resp_pass = $response->fetch_object();
if ($resp_pass->password === $password)
{
	echo "Success $resp_pass->password";	
} else {
	echo "Failure $resp_pass->password";
}

mysqli_close($con);
?>