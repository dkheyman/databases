<?php 
    session_start();
    require 'db_functions.php';
    require 'helpers.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
        	case "get_user":
        		echo $_SESSION['userID'];
        		return $_SESSION['userID'];
        		break;
            case "get_recommendations":
                if (isset($_POST['userID']) && strlen($_POST['userID']) > 0) {
                    get_recommendations();
                }
                else {
                    echo "User cannot be found";
                }
                break;
            case "get_current_bids":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0) {
                    get_current_bids();
                }
        		else {
        			echo "User cannot be found";
        		}
        		break;
        	case "get_watches":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
        			get_watches();
        		else {
        			echo "User cannot be found";
           		}
        		break;
        	case "get_past_bids":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
        			get_past_bids();
        		else {
        			echo "User cannot be found";
        		}
        		break;
            case "get_current_aucs":
                if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
                    get_current_aucs();
                else {
                    echo "User cannot be found";
                }
                break;
            case "get_past_aucs":
                if(isset($_POST['userID']) && strlen($_POST['userID']) > 0)
                    get_past_aucs();
                else {
                    echo "User cannot be found";
                }
                break;
        	default:
                echo "Wrong";
        }
    }

    function get_recommendations(){
        $current_time = current_time();
        $query = "SELECT auction.auctionID, isbn, asking_price, value, userID, end_time
                FROM auction JOIN bid ON auction.auctionID = bid.auctionID 
                WHERE bid.buyerID IN (SELECT buyerID FROM (SELECT auction.auctionID 
                    FROM (auction JOIN bid ON auction.auctionID = bid.auctionID) WHERE bid.buyerID = ?) d1 
                    JOIN bid b ON d1.auctionID = b.auctionID WHERE b.buyerID <> ?) 
                AND auction.auctionID NOT IN (SELECT auction.auctionID 
                    FROM (auction JOIN bid ON auction.auctionID = bid.auctionID) WHERE bid.buyerID = ?)
                AND aution.end_time > ?";
        $args = array($_SESSION['userID'], $_SESSION['userID'], $_SESSION['userID'], $current_time);
        $result = run_query($query, 'ssss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No Recommendations";
        }
    }
    
    function get_current_bids(){
        $current_time = current_time();
    	$query = "SELECT auction.auctionID, isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
				WHERE bid.buyerID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No Current Bids";
        }
    }
    function get_watches(){
        $current_time = current_time();
    	$query = "SELECT auction.auctionID, isbn, asking_price, starting_price, userID, end_time
				FROM (auction JOIN watch
				ON auction.auctionID = watch.auctionID)
				WHERE watch.buyerID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No current watches";
        }
    }

    function get_past_bids(){
        $current_time = current_time();
        $query = "SELECT auction.auctionID, isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
                WHERE bid.buyerID = ?
                AND auction.end_time <= ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No past bids";
        }
    }
    function get_current_aucs(){
        $current_time = current_time();
        $query = "SELECT Auction.auctionID, Auction.isbn, asking_price, starting_price, end_time,
                title, aLast, aFirst, book_condition, genre, publisher, language, data
                FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE auction.userID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No current auctions";
        }
    }

    function get_past_aucs(){
        $current_time = current_time();
        $query = "SELECT auction.auctionID, isbn, asking_price, starting_price, end_time
                FROM auction
                WHERE auction.userID = ?
                AND auction.end_time <= ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result);
        } else {
            echo "No past auctions";
        }
    }
?>
