<?php 
    include 'connect_db.php';

    $con = connect_to_db("bookly");
    
    function reset_password($username, $email) {
        $new_password = rand_string(10);
        $query = "UPDATE Users SET password=$new_password WHERE username='$username' AND email='$email'";
        mysqli_db_query($con, $query);
    }

    // build a random password from the valid ASCII characters of length $length
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0 ,$length);
    }
