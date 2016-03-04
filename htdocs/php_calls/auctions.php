<?php
session_start();
require 'db_functions.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
		case "get_all_active_auctions":
				get_all_active_auctions();
        		break;
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
				WHERE auction.end_time > " . $current_time . " ;";
	$result = run_query($query);
	//$result = run_query($query);
	for (int $i = 0; $i < count($result); $i++) {
		for (int $j = 0; $j < count($result[$i]); $j++) {
			echo $result[$i][$j];
		}
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
	$result = run_query($query);
	for (int $i = 0; $i < count($result); $i++) {
		for (int $j = 0; $j < count($result[$i]); $j++) {
			echo $result[$i][$j];
		}
	}
}

?>