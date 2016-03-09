<?php
session_start();

    require 'db_functions.php';
    require 'helpers.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
		case "get_all_active_auctions":
			get_all_active_auctions();
            break;
        case "get_auction_by_id":
            if (isset($_POST['auction']) && !empty($_POST['auction'])) {
                get_auction($_POST['auction']);
            } else {
                echo 0;
            }
            break;
        default:
            echo "Wrong";
            break;
    }
}

function get_users_auctions($userID) {
    $query = "SELECT asking_price, Auction.isbn, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date 
				FROM (Auction JOIN Book
				ON Auction.isbn = Book.isbn) 
                WHERE Auction.userID = ?";
    $args = array($userID);
	$result = run_query($query, 's', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "User $userID has no auctions";
    }
}

function get_all_active_auctions() {
	$current_time = current_time();
    $query = "SELECT asking_price, Auction.isbn, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date
				FROM (Auction JOIN Book
                ON Auction.ISBN = Book.isbn)
                WHERE Auction.end_time > ?";
    $args = array($current_time);
	$result = run_query($query, 's', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No active auctions";
    }
}

function get_all_auctions() {
    $query = "SELECT asking_price, Auction.isbn, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date
				FROM (Auction JOIN Book
				ON Auction.isbn = Book.isbn)"; 
    $args = array();
	$result = run_query($query, '', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No auctions found";
    }
}

?>
