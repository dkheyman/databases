<?php
    session_start();
    require 'db_functions.php';
    require 'helpers.php';
    
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
            case "add_bid":
                if (isset($_POST['buyerID']) && !empty($_POST['buyerID']) && isset($_POST['auctionID']) && !empty($_POST['auctionID']) && isset($_POST['value']) && !empty($_POST['value']) && isset($_POST['password']) && !empty($_POST['password'])) {
                    ob_start();
                    check_password($_POST['buyerID'], $_POST['password']);
                    $check = ob_get_clean();
                    if ($check == 1) {
                        add_bid($_POST['buyerID'], $_POST['auctionID'], $_POST['value']);
                    } else {
                        echo "Invalid password, please try again!";
                    }
                } else {
                    echo "Invalid input";
                }
                break;
            default:
                echo "Wrong";
                break;
        }
    }
    
    function add_bid($buyerID, $auctionID, $value) {
        $found_auction = find_auctionID($auctionID);
        if ($found_auction) {
            list($start_time, $end_time) = find_auction_start_end($auctionID);
            $asking_price = find_auction_value($auctionID);
            if ($start_time > current_time()) {
                echo "Auction $auctionID has not started yet!";
                return;
            }
            if ($end_time < current_time()) {
                echo "Auction $auctionID has ended!";
                return;
            }
            if ($asking_price >= $value) {
                echo "Your bid is too low! Current asking price is $asking_price";
                return;
            }
            if (filter_var($value, FILTER_VALIDATE_FLOAT) === 'false' ) {
                echo "Your value $value is not valid! Please enter a value in the form 12.34";
                return;
            }
            if (!insert_bid_record($auctionID, $buyerID, $value)) {
                echo "Inserting bid record failed";
            } else {
                $sellerID = find_sellerID($auctionID);
                if (!$sellerID) {
                    echo "Auction $auctionID has no seller";
                    return;
                } else {
                    if (update_auction_price($auctionID, $value)) {
                        if (email_bid_update("BID", $buyerID, $auctionID, $value) && email_bid_update("UPDATE", $sellerID, $auctionID, $value)) {
                            echo 1;
                        } else {
                            echo "Emailing bid updates failed";
                        }
                    } else {
                        echo "Updating the auction price failed";
                    }    
                }
            }
        } else {
            echo "Auction $auctionID does not exist";
        }
    }

    function insert_bid_record($auctionID, $buyerID, $value) {
        $query = "INSERT INTO Bid (auctionID, buyerID, value) VALUES (?, ?, ?)";
        $args = array($auctionID, $buyerID, $value);
        $results = execute_change($query, 'ssd', $args);
        if (is_string($results)) {
            return 0;
        } else {
            return 1;
        }
    }

    function update_auction_price($auctionID, $value) {
        $query = "UPDATE Auction SET asking_price=? where auctionID=?";
        $args = array($value, $auctionID);
        $results = execute_change($query, 'ds', $args);
        if (is_string($result)) {
            return;
        } else {
            return 1;
        }
    } 

    function email_bid_update($type, $userID, $auctionID, $value) {
        $email = find_email($userID);
        $subject = "Bid Submitted!";
        $message = '';
        ob_start();
        $auction = get_auction($auctionID);
        ob_get_clean();
        $title = $auction[0][3];
        $isbn = $auction[0][1];
        if (!$title || !$isbn) {
            echo "Book being sold in auction $auctionID not found!";
            return;
        }
        
        list($start_time, $end_time) = find_auction_start_end($auctionID);
        $asking_price = find_auction_value($auctionID);
        //$headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
        switch($type) {
            case "BID":
                $message = "You have submitted a bid on for auction \"$auctionID\"!\n\n";
                $details = "Bid Details:\n\n\t\tBook: \"$title\"\n\t\tISBN Number: $isbn\n\t\tBid Value: $$value\n\t\tAuction Ends At: $end_time\n\t\t";
                $closing = "\n\nThank you for bidding!\n\nSincerely,\nBookly.com";
                $message = $message . $details . $closing;
                break;
            case "UPDATE":
                $message = "Your auction \"$auctionID\" has been bid on!\n\n";
                $details = "Bid Details:\n\n\t\tBidder: $userID\n\t\tBook: \"$title\"\n\t\tISBN Number: $isbn\n\t\tNew Asking Price: $$asking_price\n\t\t";
                $closing = "\n\nSincerely, \nBookly.com";
                $message = $message . $details . $closing;
                break;
        }
        return mail($email, $subject, $message);
    }
