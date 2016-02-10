<?php 
    require 'connect_db.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
                case "check":
                    check_password($_POST['username'], $_POST['old_password']);
                    break;
                case "reset":
                    reset_password($_POST['username'], $_POST['email']);
                    break;
                case "change":
                    change_password($_POST['username'], $_POST['old_password'], $_POST['new_password']);
                    break;
                default:
                    echo "Wrong";
        }
    } 

    function reset_password($username, $email) {
        $con = connect_to_db("bookly");
        $new_password = rand_string(10);
        $query = "UPDATE Users SET password='$new_password' WHERE username='$username' AND email='$email'";
        if(!mysqli_query($con, $query)) {
            echo "Incorrect username or email. Please try again!" . mysqli_error($con);
        }
        else {
            echo "Password for $username reset successfully!";
        }
        mysqli_close($con);
        email_password_change($email, "RESET");
    }

    function email_password_change( $email, $type ) {
        $subject = "Bookly Password " . $type;
        $message = "Your bookly password has been reset!\r\n\r\nSincerely, Bookly Engineering Team";
        return mail($email, $subject, $message);
    }

    function find_username($username) {
        $con = connect_to_db("bookly");
        $query = "SELECT count(username) as quantity from Users where username='$username'";
        $result = mysqli_query($con, $query);
        mysqli_close($con);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $username = $row["password"];
            echo $username;
            return;
        }
        else {
            return;
        } 
    }

    function check_password($username, $old_password) {
        $con = connect_to_db("bookly");
        $query = "SELECT password from Users where username='$username'";
        $result = mysqli_query($con, $query);
        $password = '';
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $password = $row["password"];
        } else {
            echo 0;
            return;
        }    
        mysqli_close($con);
        if ($old_password == $password) {
            echo 1;
            return;
        }
        echo 0;
        return;
    }

    function change_password($username, $old_password, $new_password) {
        $con = connect_to_db("bookly");
        $query = "UPDATE Users SET password='$new_password' WHERE username='$username' AND password='$old_password'";
        if (!mysqli_query($con, $query)) {
            echo "Incorrect username or password. Please try again!" . mysqli_error($con);
        }
        else {
            echo "Password for $username changed successfully!";
        }
        $result;
        $query = "SELECT email from Users WHERE username='$username'";
        if (($result = mysqli_query($con, $query)) && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $email = $row["email"];
            if (!email_password_change($email, "CHANGE")) {
                echo "Something went wrong when emailing password change\n";
            }
        }
        else {
            echo "Email does not exist\n";
        }
        mysqli_close($con);
    }

    // build a random password from the valid ASCII characters of length $length
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0 ,$length);
    }
?>
