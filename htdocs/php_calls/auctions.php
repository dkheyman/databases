<?php
session_start();
require 'db_functions.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
		case "get_all_active_auctions":
			get_all_active_auctions();
            break;
        case "get_auction_id":
            get_auction_id();
            break;
        case "get_auction_by_id":
            if (isset($_POST['auction']) && !empty($_POST['auction'])) {
                get_auction($_POST['auction']);
            } else {
                echo 0;
            }
            break;
        case "get_genre":
        	get_genre();
        	break;
        case "get_active_auctions":
        	if (isset($_POST['genre']) && !empty($_POST['genre'])) {
        		if($_POST['genre'] == "none") {
        			get_all_active_auctions();
        		} else {
        			get_active_auctions_by_genre($_POST['genre']);
        		}
        	} else
        		echo 0;
        	break;
        case "get_available_genres":
        	get_available_genres();
        	break;
        default:
            echo "Wrong";
    }
}
function get_genre() {
	return $_GET['genre'];
}

function get_auction_id() {
    return $_GET['auction_id'];
}

function get_users_auctions($userID) {
	$query = "SELECT asking_price, end_time, title, COUNT(*) as count
				FROM (auction JOIN book
				ON auction.ISBN = book.ISBN) JOIN view
				ON auction.auctionID = view.auctionID
				WHERE auction.sellerID = " . $userID ." ;";
	$result = run_query($query);
	for (int $i = 0; $i < count($result); $i++) {
		for (int $j = 0; $j < count($result[$i]); $j++) {
			echo $result[$i][$j];
		}
	}
}

function get_all_active_auctions() {
$current_time = date('Y-m-d H:i:s', time());
	$query = "SELECT asking_price, end_time, title, COUNT(*) as count
				FROM (auction JOIN book
				ON auction.ISBN = book.ISBN) JOIN view
				ON auction.auctionID = view.auctionID
				WHERE auction.end_time > ? ;";
	$args = array($current_time);
	$result = run_query($query, 'ss', $args);
	if (is_array($result) && count($result) > 0) {
		echo json_encode($result);
	} else {
		echo 0;
	}
}

function get_active_auctions_by_genre($genre) {
	$current_time = date('Y-m-d H:i:s', time());
	$query = "SELECT asking_price, end_time, title, COUNT(*) as count
				FROM (auction JOIN book
				ON auction.ISBN = book.ISBN) JOIN view
				ON auction.auctionID = view.auctionID
				WHERE auction.end_time > ?
				AND book.genre = ? ;";
	$args = array($current_time, $genre);
	$result = run_query($query, 'ss', $args);
	if (is_array($result) && count($result) > 0) {
		echo json_encode($result);
	} else {
		echo 0;
	}
}

function get_all_auctions() {
	$query = "SELECT asking_price, end_time, title, COUNT(*) as count
				FROM (auction JOIN book
				ON auction.ISBN = book.ISBN) JOIN view
				ON auction.auctionID = view.auctionID;";
	$result = run_query($query);
	$result = run_query($query);
	for (int $i = 0; $i < count($result); $i++) {
		for (int $j = 0; $j < count($result[$i]); $j++) {
			echo $result[$i][$j];
		}
	}
}

function get_auction($aucID) {
	$query = "SELECT asking_price, end_time, title, COUNT(*) as count
				FROM (auction JOIN book
				ON auction.ISBN = book.ISBN) JOIN view
				ON auction.auctionID = view.auctionID;
				WHERE auction.userID = " . $aucID . " ;";
	$result = run_query($query);
	for (int $i = 0; $i < count($result); $i++) {
		for (int $j = 0; $j < count($result[$i]); $j++) {
			echo $result[$i][$j];
		}
	}
}

function get_available_genres($aucID) {
	$query "SELECT DISTINCT genre
			FROM ?";
	$args = array("book");
	$result = run_query($query, "s", $args);
	if (is_array($result) && count($result) > 0) {
		echo json_encode($result);
	} else {
		echo 0;
	}

}

?>
