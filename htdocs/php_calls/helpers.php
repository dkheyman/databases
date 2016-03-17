<?php

    function check_finished_auctions() {
        $current_time = current_time();
        $query = "SELECT auctionID from Auction
            WHERE finished = 0
            AND end_time <= ?";
        $args = array($current_time);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) > 0) {
            lockdown_auctions($result);
            return $result;
        } else {
            return 0;
        }
    }

    function lockdown_auctions($result) {
        $query = "UPDATE Auction SET finished=1
            WHERE auctionID = ?";
        $ret = 1;
        for ($i = 0; $i < count($result); $i++) {
            $args = array($result[$i][0]);
            $results = execute_change($query, 's', $args);
            if (is_string($results)) {
                $ret = $ret && 0;
            } else {
                $ret = $ret && 1;
            }
        }
        return $ret;
    }
    
    function email_finished_auction($auctionID) {
        ob_start();
        $auction = get_auction($auctionID);
        ob_get_clean();
        $asking_price = $auction[0][0];
        $isbn = $auction[0][1];
        $title = $auction[0][3];
        $ownerID = $auction[0][11];
        $email = find_email($ownerID);
        $subject = "Auction Concluded!";
        $message = "Your auction \"$auctionID\" has concluded!\n\n";
        $details = '';
        list($winnerID, $value) = get_winning_bid($auctionID);
        if (!$winnerID && !$value) {
            $details = "Unfortunately, your auction had no bidders. Please re-add your auction if you wish to restart it.\n\nYour auction is now closed!\n\n";    
        } else {
            email_winning_bidder($winnerID, $auctionID, $value, $title, $isbn);
            $details = "Information: \n\t\tTitle: \"$title\"\n\t\tISBN: $isbn\n\t\tWinning Bidder: $winnerID\n\t\tWinning Price: $value\n\nYour auction is now closed!\n\n";
        }
        $closing = "Sincerely, \nBookly.com";
        $message = $message . $details . $closing;
        return mail($email, $subject, $message);
    }

    function email_winning_bidder($winnerID, $auctionID, $value, $title, $isbn) {
        $email = find_email($winnerID);
        $subject = "Congratulations! You're A Winner!";
        $message = "You have won auction \"$auctionID\" for your winning bid of $$value. Please pay immediately at: \n\n\t\thttp://localhost:8888/html/pay.php?auction_id=$auctionID\n\n";
        $details = "Book Details: \n\t\tTitle: \"$title\"\n\t\tISBN: $isbn\n\n";
        $closing = "Sincerely, \nBookly.com";
        $message = $message . $details . $closing;
        return mail($email, $subject, $message);
    }


    function get_winning_bid($auctionID) {
        $query = "SELECT buyerID, MAX(value) as value from Bid WHERE auctionID=?";
        $args = array($auctionID);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) == 1) {
            return $result[0];
        } else {
            return;
        }
    }

    function find_userID($userID) {
        $query = "SELECT userID from Users where userID=?";
        $args = array($userID);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) == 1) {
            return 1;
        }
        else {
            return 0;
        } 
    }

    function find_email($userID) {
        $query = "SELECT email from Users WHERE userID=?";
        $args = array($userID);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) == 1) {
            $email = $result[0][0];
            return $email;
        }
        else {
            return;
        }
    }

   function check_password($userID, $old_password) {
        $query_password = sha1($old_password);
        $query = "SELECT password from Users where userID=? and password=?";
        $args = array($userID, $query_password);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) == 1 ) {
            echo 1;
            return;
        } else {
            echo 0;
            return;
        }    
    } 
    
    function find_sellerID($auctionID) {
        $query = "SELECT userID from Auction where auctionID=?";
        $args = array($auctionID);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return $results[0][0];
        } else {
            return;
        }    
    }

    function find_auctionID($auctionID) {
        $query = "SELECT auctionID from Auction where auctionID=?";
        $args = array($auctionID);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function find_book_picture($isbn) {
        $query = "SELECT imageURL from Book where isbn=?";
        $args = array($isbn);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return $results[0][0];
        } else {
            return;
        }
    }    

    function find_auction_start_end($auctionID) {
        $query = "SELECT start_time, end_time from Auction where auctionID=?";
        $args = array($auctionID);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return $results[0];
        } else {
            return;
        }
    }
    
    function get_auction($aucID) {
    $query = "SELECT asking_price, Auction.isbn, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date, Auction.userID 
                FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE Auction.auctionID = ?";
    $args = array($aucID);
    $result = run_query($query, 's', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
        return $result;
    } else {
        echo "Auction $aucID does not exist";
        return;
    }
} 
    
    function find_auction_value($auctionID) {
        $query = "SELECT asking_price from Auction where auctionID=?";
        $args = array($auctionID);
        $results = run_query($query, 's', $args);
        if (is_array($results) && count($results) == 1) {
            return $results[0][0];
        } else {
            return;
        }
    }
    
    function current_time() {
        return date('Y-m-d H:i:s', time());
    }
?>
