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
        		if (isset($_POST['userID']))
        			get_current_bids();
        		else {
        			echo 0;
        			return 0;
        		}
        		break;
        	case "get_watches":
        		if (isset($_POST['userID']))
        			get_watches();
        		else {
        			echo 0;
        			return 0;
           		}
        		break;
        	case "get_past_bids":
        		if (isset($_POST['userID']))
        			get_past_bids();
        		else {
        			echo 0;
        			return 0;
        		}
        		break;
        	default:
                echo "Wrong";
        }
    }
    function get_current_bids(){
    	$query = "SELECT isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
				WHERE bid.buyerID = " . $_SESSION['userID'] .
				"AND auction.end_time > " . $current_time . " ;";
    	$result = run_query($query);
    	echo $result;
    }
    function get_watches(){
    	$query = "SELECT isbn, asking_price, value, userID, end_time
				FROM (auction JOIN watch
				ON auction.auctionID = watch.auctionID)
				WHERE watch.buyerID = " . $_SESSION['userID'] .
				"AND auction.end_time > " . $current_time . " ;";
    	$result = run_query($query);
    	echo $result;
    }
    function get_past_bids(){
    	$query = "SELECT isbn, asking_price, value, userID, end_time
				FROM (auction JOIN bid
				ON auction.auctionID = bid.auctionID)
				WHERE bid.buyerID = " . $_SESSION['userID'] .
				"AND auction.end_time <= " . $current_time . " ;";
    	$result = run_query($query);
    	echo $result;
    }
?>