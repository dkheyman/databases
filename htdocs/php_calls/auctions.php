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
        case "add_book":
            if (isset($_POST['title']) && !empty($_POST['title']) &&
                isset($_POST['isbn']) && !empty($_POST['isbn']) &&
                isset($_POST['aFirst']) && !empty($_POST['aFirst']) &&
                isset($_POST['aLast']) && !empty($_POST['aLast']) &&
                isset($_POST['genre']) && !empty($_POST['genre']) &&
                isset($_POST['publisher']) && !empty($_POST['publisher']) &&
                isset($_POST['language']) && !empty($_POST['language']) &&
                isset($_POST['date']) && !empty($_POST['date']) &&
                isset($_POST['condition']) && !empty($_POST['condition']) &&
                isset($_POST['binding']) && !empty($_POST['binding'])){

                add_book();
            } else {
                echo 0;
            }
            break;
        case "get_genre":
            get_genre();
            break;
        case "get_active_auctions":
            if (isset($_POST['genre']) && !empty($_POST['genre'])) {
                get_active_auctions_by_genre($_POST['genre']);
            } else
                get_all_active_auctions();
            break;
        case "get_available_genres":
            get_available_genres();
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
    $query = "SELECT Auction.auctionID, isbn, asking_price, starting_price, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date
				FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE Auction.end_time > ?";
    $args = array($current_time);
	$result = run_query($query, 'ssddsssssssss', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No active auctions";
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
              FROM Book";
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
    $aucID = "";
    for ($i = 0; $i < 32; $i++) {
        $aucID = $aucID . chr(rand(65,90));
    }
    $query = "INSERT INTO Auction (auctionID,
            asking_price, starting_price, userID,
            isbn, start_time, end_time, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $args = array($aucID, $_POST['startPrice'], $_POST['startPrice'],
        $_POST['userID'], $_POST['isbn'], $current_time,
        $_POST['endTime'], $_POST['description']);
    $result = run_query($query, 'sddsssss', $args);
    if ($result == 1)
        echo 1;
    else
        echo 0;
}

function get_available_genres($aucID) {
    $query = "SELECT DISTINCT genre
            FROM ?";
    $args = array("Book");
    $result = run_query($query, "s", $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo 0;
    }
}


function add_book() {
    $query = "INSERT INTO book (title,
            isbn, aFirst, aLast,
            genre, publisher, language, date,
            condition, binding /*TODO: image url*/)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $args = array($aucID, $_POST['title'], $_POST['isbn'],
        $_POST['aFirst'], $_POST['aLast'], $_POST['genre'],
        $_POST['publisher'], $_POST['language'], $_POST['date'],
        $_POST['condition'], $_POST['binding']);
    $result = run_query($query, 'ssssssssss', $args);
    if ($result == 1)
        echo 1;
    else
        echo 0;
}
?>
