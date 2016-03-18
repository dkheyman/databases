<?php 
    session_start();
    require 'db_functions.php';
    require 'helpers.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $check_fin = check_finished_auctions();
        if (is_array($check_fin)) {
            for($i = 0; $i < count($check_fin); $i++) {
                email_finished_auction($check_fin[$i][0]);
            }
        }

        $action = $_POST['action'];
        switch($action) {
                case "reset":
                    if (isset($_POST['userID']) && isset($_POST['email'])) {
                        reset_password($_POST['userID'], $_POST['email']);
                    }
                    break;
                case "change":
                    if (isset($_POST['userID']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
                        change_password($_POST['userID'], $_POST['old_password'], $_POST['new_password'], $_POST['confirm_password']);
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
                case "grab_usertype":
                    $userID = $_SESSION['userID'];
                    if (isset($userID)) {
                        grab_usertype($userID);
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
        //$new_password = mysqli_real_escape_string($new_password);
        if (find_userID($userID) && (find_email($userID) == $email)) {
            $query_password = sha1($new_password);
            $query = "UPDATE Users SET password=? WHERE userID=? AND email=?";
            $args = array($query_password, $userID, $email);
            $result = execute_change($query, 'sss', $args);
            if(is_string($result)) {
                echo "Something went wrong with the execution. Please try again again!";
            }
            else {
                if(email_password_change($email, "RESET", $new_password)) {
                    echo 1;
                } else {
                    echo "Password reset but email failed";
                }
            }
        }
        else {
            echo "Incorrect userID or email. Please try again!";
        }
    }

    function email_password_change( $email, $user_type, $new_password ) {
        $subject = "Bookly Password " . $user_type;
        $intermediate = '';
        $message = "Your bookly password has been reset!\n\n";
        if ($new_password != NULL) {
            $intermediate = "\nYour new password is $new_password. Please change it immediately upon following login!\n";
        }    
        $signature = "\n\n\nSincerely,\n Bookly Engineering Team";
        $message .= $intermediate . $signature;
        return mail($email, $subject, $message);
    }
    
    function test_password($password) {
        if (strlen($password) < 8) {
            echo "Password too short!";
            return;
        }
        if (!preg_match("#[0-9]+#", $password)) {
            echo "Password must include at least one number!";
            return;
        }
        if (!preg_match("#[a-zA-Z]+#", $password)) {
            echo "Password must include at least one letter!";
            return;
        }
        echo 1;
    }

    function grab_usertype($userID) {
        $query = "SELECT type from Users where userID=?";
        $args = array($userID);
        $result = run_query($query, 's', $args);
        if (count($result) == 1 && is_array($result)) {
            $usertype = $result[0][0];
            echo $usertype;
        } else {
            echo 0;
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
               echo "Incorrect username/password. Please try again!";
                return;
           }
        } else {
            echo "Username $userID does not exist!";
            return;
        }
    } 

    function find_book_being_sold($auctionID) {
        $query = "SELECT title, isbn, imageURL from (Book JOIN
                Auction on Auction.isbn = Book.isbn) WHERE
                Auction.auctionID = ?";
        $args = array($auctionID);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return $results[0];
        } else {
            return;
        }
    }

    function change_password($userID, $old_password, $new_password, $confirm_password) {
        ob_start();
        check_password($userID, $old_password);
        $password_ok = ob_get_clean();
        if ($password_ok == 1) {
            if (!($confirm_password === $new_password) ) { echo "Passwords don't match!"; return; }
            ob_start();
            test_password($new_password);
            $password_strong = ob_get_clean(); 
            if ($password_strong == 1) {
                $query_password = sha1($new_password);
                $query = "UPDATE Users SET password=? where userID=?";
                $args = array($query_password, $userID);
                $result = execute_change($query, 'ss', $args);
                if (is_string($result)) {
                    echo $result; 
                    return;
                }
                else {
                    echo 1;
                }
                $email = find_email($userID);
                if (!$email) {
                    echo "Email for $userID does not exist\n";
                    return;
                }
                if (!email_password_change($email, "CHANGE", NULL)) {
                    echo "Something went wrong when emailing password change\n";
                    return;
                }
            } else {
                echo $password_strong;
                return;
            }
        }
        else {
            echo $password_ok . "Username and password combination is incorrect. Please try again";
            return;
        }
    }

    // build a random password from the valid ASCII characters of length $length
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0 ,$length);
    }

    function add_user($userID, $password, $email, $user_type ) {
        ob_start();
        test_password($password);
        $test = ob_get_clean();
        if ($test != 1) {
            echo $test;
            return;
        }
        $result = find_userID($userID);
        if ($result == 1) {
            echo "UserID $userID already exists!\n";
            return;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo "Email $email contains invalid characters";
            return;
        }
        $password = sha1($password);
        $query = "INSERT INTO Users (userID, password, email, type) VALUES (?, ?, ?, ?)";
        $args = array($userID, $password, $email, $user_type);
        $result = execute_change($query, 'ssss', $args);
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

