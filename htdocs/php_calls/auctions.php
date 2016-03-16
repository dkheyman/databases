<?php
session_start();

    require 'db_functions.php';
    require 'helpers.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $check_fin = check_finished_auctions();
    if (is_array($check_fin)) {
        for($i = 0; $i < count($check_fin); $i++) {
            email_finished_auction($check_fin[$i][0]);
        }
    } 

	$action = $_POST['action'];
	switch($action) {
		case "get_all_active_auctions":
			get_all_active_auctions();
            break;
        case "get_auction_by_id":
            if (isset($_POST['auction']) && !empty($_POST['auction'])) {
                get_auction($_POST['auction']);
                add_auction_view($_POST['auction']);
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
                echo "Invalid parameters";
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
        case "get_bids_by_id":
            if (isset($_POST['auction']) && !empty($_POST['auction'])) {
                get_bids_by_id($_POST['auction']);
            } else {
                echo "Invalid auctionID";
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
    $query = "SELECT Auction.auctionID, Auction.userID, Auction.isbn, asking_price, starting_price, end_time, title,
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

function get_bids_by_id($auctionID) {
    $query = "SELECT buyerID, value from Bid WHERE auctionID=? ORDER BY value DESC";
    $args = array($auctionID);
    $result = run_query($query, 's', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No current bids";
    }
}

function get_all_active_auctions() {
	$current_time = current_time();
    $query = "SELECT Auction.auctionID, Auction.userID, Auction.isbn, asking_price, starting_price, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date
				FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE Auction.end_time > ?";
    $args = array($current_time);
	$result = run_query($query, 's', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No active auctions";
    }
}

function get_active_auctions_by_genre($genre) {
    $current_time = current_time();
    $query = "SELECT Auction.auctionID, Auction.userID, Auction.isbn, asking_price, starting_price, end_time, title,
                aLast, aFirst, book_condition, genre, publisher, language, date
                FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE Auction.end_time > ?
                AND Book.genre = ?";
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
    $query = "SELECT title, isbn 
              FROM Book";
    $args = array();
    $result = run_query($query, '', $args);
    if (is_array($result) && count($result) > 0) {
        echo json_encode($result);
    } else {
        echo "No books found";
    }
}

function add_auction_view($auctionID) {
    $current_time = current_time();
    list($start_time, $end_time) = find_auction_start_end($auctionID);
    if (($start_time > $current_time) || ($end_time < $current_time)) {
        return;
    }
    $viewerID = $_SESSION['userID'];
    $sellerID = find_sellerID($auctionID);
    if ($sellerID == $viewerID) {
        return;
    }
    $query = "INSERT into View (buyerID, auctionID, timestamp)
        VALUES (?, ?, ?)";
    $args = array($viewerID, $auctionID, $current_time);
    $result = execute_change($query, 'sss', $args);
    if (!is_string($result)) {
        return;
    } else {
        return;
    }
}

function add_auction() {
    $current_time = current_time();
    $aucID = "";
    for ($i = 0; $i < 32; $i++) {
        $aucID = $aucID . chr(rand(65,90));
    }
    if ($_POST['endTime'] < $current_time) {
        echo "Auction end time is not valid";
        return;
    }
    if (filter_var($_POST['startPrice'], FILTER_VALIDATE_FLOAT) === 'false') {
        echo "Your auction starting price is invalid!";
        return;
    }
    $query = "INSERT INTO Auction (auctionID,
            asking_price, starting_price, userID,
            isbn, start_time, end_time, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $args = array($aucID, $_POST['startPrice'], $_POST['startPrice'],
        $_POST['userID'], $_POST['isbn'], $current_time,
        $_POST['endTime'], $_POST['description']);
    $result = execute_change($query, 'sddsssss', $args);
    if (!is_string($result)) {
        $result = email_auction($_POST['userID']);
        if ($result == 1) {
            echo $aucID;
        } else {
            echo "Emailing auction failed";
        }
    } else {
        echo 0;
    }
}

function email_auction($userID) {
    $email = find_email($userID);
    $subject = "Auction Submitted!";
    $names = array("Asking Price", "ISBN", "End Time", "Description");
    $elems = array($_POST['startPrice'], $_POST['isbn'], $_POST['endTime'], $_POST['description']);
    $message = "Your auction has been recorded. Here are the details:\n\n";
    $details = "";
    for ($i = 0; $i < 4; $i++) {
        $details .= "\n\t\t" . $names[$i] . ": " . $elems[$i];
    }
    $closing = "\n\nSincerely,\nBookly.com";
    $message = $message . $details . $closing;
    return mail($email, $subject, $message);
}

function get_available_genres() {
    $query = "SELECT DISTINCT genre
            FROM Book";
    $args = array();
    $result = run_query($query, "", $args);
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
