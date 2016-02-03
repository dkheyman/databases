<?php
    include 'connect_db.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $type = $_POST['type'];

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

    $userID = generate_userID();

    $query = "INSERT INTO Users (userID, username, password, email, type) VALUES ('$userID', '$username', '$password', '$email', '$type')";

    $con = connect_to_db("bookly");
    mysqli_query($con, $query);
    mysqli_close($con);
?>
