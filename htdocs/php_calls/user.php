<?php 
    session_start();
    require 'db_functions.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch($action) {
        	case "get_user":
        		echo $_SESSION['userID'];
        		return $_SESSION['userID'];
        		break;
            case "get_current_bids":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0) {
                    get_current_bids();
                }
        		else {
        			echo "Hello";
        			return 0;
        		}
        		break;
        	case "get_watches":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
        			get_watches();
        		else {
        			echo 0;
        			return 0;
           		}
        		break;
        	case "get_past_bids":
        		if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
        			get_past_bids();
        		else {
        			echo 0;
        			return 0;
        		}
        		break;
            case "get_current_aucs":
                if (isset($_POST['userID']) && strlen($_POST['userID']) > 0)
                    get_current_aucs();
                else {
                    echo 0;
                    return 0;
                }
                break;
            case "get_past_aucs":
                if(isset($_POST['userID']) && strlen($_POST['userID']) > 0)
                    get_past_aucs();
                else {
                    echo 0;
                    return 0;
                }
                break;
        	default:
                echo "Wrong";
        }
    }
    
    function current_time() {
        return date('Y-m-d H:i:s', time());
    }

    function get_current_bids(){
        $current_time = current_time();
    	$query = "SELECT isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
				WHERE bid.buyerID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
    	    print_r($result);
        } else {
            echo "No Current Bids";
        }
    }
    function get_watches(){
        $current_time = current_time();
    	$query = "SELECT isbn, asking_price, starting_price, userID, end_time
				FROM (auction JOIN watch
				ON auction.auctionID = watch.auctionID)
				WHERE watch.buyerID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            print_r($result);
        } else {
            echo "No current watches";
        }
    }

    function get_past_bids(){
        $current_time = current_time();
        $query = "SELECT isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
                WHERE bid.buyerID = ?
                AND auction.end_time <= ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            print_r($result);
        } else {
            echo "No past bids";
        }
    }
    function get_current_aucs(){
        $current_time = current_time();
        $query = "SELECT isbn, asking_price, value, end_time
                FROM auction
                WHERE auction.sellerID = ?
                AND auction.end_time > ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo $result;
        } else {
            echo "No current auctions";
        }
    }

    function get_past_aucs(){
        $current_time = current_time();
        $query = "SELECT isbn, asking_price, value, end_time
                FROM auction
                WHERE auction.sellerID = ?
                AND auction.end_time <= ?";
        $args = array($_SESSION['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            echo $result;
        } else {
            echo "No past auctions";
        }
    }
?>
