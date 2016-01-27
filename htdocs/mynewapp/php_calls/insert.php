<?php
$database = "bookly";
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$type = $_POST['type'];

$con = mysqli_connect('localhost', 'root', 'root', 'bookly');
if (!$con) {
    echo mysqli_error($con);
    die('Could not connect to database: ' . mysqli_error($con));
}
mysqli_select_db($con, "$database");

function generate_userID() {
    $userID = rand(0, 65536);
    // do check on if userID is unique
    return strval($userID);
}

function generate_error_popup($error) {
    echo "<script type='text/javascript'>\n";
    echo "alert('Error: ' . $error)";
    echo "</script>";
}
generate_error_popup("Hello");
$userID = generate_userID();

$query = "INSERT INTO Users (userID, username, password, email, type) VALUES ('$userID', '$username', '$password', '$email', '$type')";
echo "$query";
/*if(!mysqli_query($con, $query)) {
    $error_message = mysqli_error($con);
    echo "$error_message";
    generate_error_popup($error_message);
}
 */
mysqli_query($con, $query);
mysqli_close($con);
?>
