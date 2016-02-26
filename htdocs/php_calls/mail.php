<?php 
    session_start();
    require 'db_functions.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
                case "check":
                    if (isset($_POST['userID']) && isset($_POST['old_password'])) {
                        check_password($_POST['userID'], $_POST['old_password']);
                    }
                    break;
                case "reset":
                    if (isset($_POST['userID']) && isset($_POST['email'])) {
                        reset_password($_POST['userID'], $_POST['email']);
                    }
                    break;
                case "change":
                    if (isset($_POST['userID']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
                        change_password($_POST['userID'], $_POST['old_password'], $_POST['new_password']);
                    }
                    break;
                case "add_user":
                    $userID = $_POST['userID'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $user_type = $_POST['user_type'];
                    if (isset($userID) && isset($password) && isset($email) && isset($user_type)) {
                        add_user($userID, $password, $email, $user_type);
                    }
                    break;
                case "login_user":
                    $userID = $_POST['userID'];
                    $password = $_POST['password'];
                    if (isset($userID) && isset($password)) {
                        login_user($userID, $password);
                    }
                    break;
                case "logout":
                    logout();
                    break;
                default:
                    echo "Wrong";
        }
    } 

    function reset_password($userID, $email) {
        $new_password = rand_string(10);
        $query = "UPDATE Users SET password='$new_password' WHERE userID='$userID' AND email='$email'";
        $result = execute_change($query);
        if($result != 1) {
            echo "Incorrect userID or email. Please try again!";
        }
        else {
            if(email_password_change($email, "RESET")) {
                echo 1;
            } else {
                echo "Password reset but email failed";
            }
        }
    }

    function email_password_change( $email, $user_type ) {
        $subject = "Bookly Password " . $user_type;
        $message = "Your bookly password has been reset!\r\n\r\nSincerely, Bookly Engineering Team";
        return mail($email, $subject, $message);
    }

    function find_userID($userID) {
        $query = "SELECT userID from Users where userID='$userID'";
        $result = run_query($query);
        //print_r($result);
        if (is_array($result) && count($result) == 1) {
            return 1;
        }
        else {
            return 0;
        } 
    }

    function login_user($userID, $password) {
        ob_start();
        check_password($userID, $password);
        $password_ok = ob_get_clean();
        if (find_userID($userID) == 1) {
           if ($password_ok == 1) {
                echo 1;
                $_SESSION["userID"] = $userID;
                return;
           } else {
               echo 0;
                return;
           }
        } else {
            echo 0;
            return;
        }
    } 

    function check_password($userID, $old_password) {
        $query = "SELECT password from Users where userID='$userID'";
        $result = run_query($query);
        $password = '';
        if (is_array($result) && count($result) == 1 ) {
            $password = $result[0][0];
        } else {
            echo 0;
            return;
        }    
        if ($old_password == $password) {
            echo 1;
            return;
        } else {
            echo 0;
            return;
        }
    }

    function change_password($userID, $old_password, $new_password) {
        $query = "UPDATE Users SET password='$new_password' WHERE userID='$userID' AND password='$old_password'";
        $result = run_query($query);
        if (is_string($result)) {
            echo "Incorrect userID or password. Please try again!" . $result; 
            return;
        }
        else {
            echo "Password for $userID changed successfully!";
        }

        $query = "SELECT email from Users WHERE userID='$userID'";
        $result = run_query($query);
        if (is_array($result) && count($result) == 1) {
            $email = $result[0][0];
            if (!email_password_change($email, "CHANGE")) {
                echo "Something went wrong when emailing password change\n";
                return;
            }
        }
        else {
            echo "Email does not exist\n";
        }
    }

    // build a random password from the valid ASCII characters of length $length
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0 ,$length);
    }

    function add_user($userID, $password, $email, $user_type ) {
        $result = find_userID($userID);
        //echo $result . " found\n";
        if ($result == 1) {
            echo "UserID $userID already exists!\n";
            return;
        }
        $query = "INSERT INTO Users (userID, password, email, type) VALUES ('$userID', '$password', '$email', '$user_type')";
        $result = run_query($query);
        if (is_string($result)) {
            echo "Adding user $userID failed: " . $result;
            return;
        } else {
            echo 1;
            $_SESSION["userID"] = $userID;
            return;
        }
    }

    function logout() {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        if (session_destroy()) {
            echo 1;
        } else {
            echo 0;
        }
    }
?>

