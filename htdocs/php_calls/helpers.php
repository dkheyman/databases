<?php

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
                aLast, aFirst, book_condition, genre, publisher, language, date 
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
