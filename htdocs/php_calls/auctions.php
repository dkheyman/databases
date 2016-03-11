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
        case "get_all_books":
            get_all_books();
            break;
        case "add_auction":
            if (isset($_POST['userID']) && !empty($_POST['userID']) &&
                isset($_POST['endTime']) && !empty($_POST['endTime']) &&
                isset($_POST['startPrice']) && !empty($_POST['startPrice']) &&
                isset($_POST['description']) && !empty($_POST['description']) &&
                isset($_POST['isbn']) && !empty($_POST['isbn'])) {

                add_auction();
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

function get_all_books() {
    $query = "SELECT *
              FROM Book"
    $args = array();
    $result = run_query($query, '', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No books found";
    }
}

function add_auction() {
    $current_time = current_time();
    var $aucID = "";
    for ($i = 0; $i < 32; $i++) {
        $aucID = $aucID . chr(rand(65,90));
    }
    chr(rand(65,90))
    $query = "INSERT INTO `bookly`.`auction` (`auctionID`,
            `asking_price`, `starting_price`, `userID`,
            `isbn`, `start_time`, `end_time`, `description`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $args = ($aucID, $_POST['startPrice'], $_POST['startPrice'],
        $_POST['userID'], $_POST['isbn'], current_time,
        $_POST['endTime'], $_POST['description']);
    $result = run_query($query, '', $args);
    if ($result == 1)
        echo 1;
    else
        echo 0;
}
?>