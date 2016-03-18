<?php 
    session_start();
    require 'db_functions.php';
    require 'helpers.php';

    if(isset($_POST['action']) && !empty($_POST['action'])) {

        $check_fin = check_finished_auctions();
        if (is_array($check_fin)) {
            for ($i = 0; $i < count($check_fin); $i++) {
                email_finished_auction($check_fin[$i][0]);
            }
        } 

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
            case "review":
                if(isset($_POST['content']) && strlen($_POST['content']) > 0 &&
                    isset($_POST['reviewee']) && strlen($_POST['reviewee']) > 0 &&
                    isset($_POST['rating']) && strlen($_POST['rating']) > 0 &&
                    isset($_SESSION['userID']) && strlen($_SESSION['userID']) > 0)
                    review();
                else
                    echo "An error occurred!";
                break;
            case "get_rating":
                if(isset($_POST['userID']) && strlen($_POST['userID'])) {
                    get_rating();
                } else
                    echo 0;
                break;
        	default:
                echo "Wrong";
        }
    }

    function get_recommendations(){
        $current_time = current_time();
        $query = "SELECT DISTINCT auction.auctionID, isbn, userID, end_time
                FROM auction JOIN bid ON auction.auctionID = bid.auctionID 
                WHERE bid.buyerID IN (SELECT buyerID FROM (SELECT auction.auctionID 
                    FROM (auction JOIN bid ON auction.auctionID = bid.auctionID) WHERE bid.buyerID = ?) d1 
                    JOIN bid b ON d1.auctionID = b.auctionID WHERE b.buyerID <> ?) 
                AND auction.auctionID NOT IN (SELECT auction.auctionID 
                    FROM (auction JOIN bid ON auction.auctionID = bid.auctionID) WHERE bid.buyerID = ?)
                AND auction.end_time > ?";
        $args = array($_POST['userID'], $_POST['userID'], $_POST['userID'], $current_time);
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
        $args = array($_POST['userID'], $current_time);
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
        $args = array($_POST['userID'], $current_time);
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
        $args = array($_POST['userID'], $current_time);
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
                title, aLast, aFirst, book_condition, genre, publisher, language, date
                FROM (Auction JOIN Book
                ON Auction.isbn = Book.isbn)
                WHERE auction.userID = ?
                AND auction.end_time > ?
                ORDER BY auction.end_time ASC";
        $args = array($_POST['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            for($i = 0; $i < count($result); $i++) {
                $count = get_views($result[$i][0]);
                array_push($result[$i], $count);
            }
            echo json_encode($result);
        } else {
            echo "No current auctions";
        }
    }

    function get_views($auctionID) {
        $query = "SELECT COUNT(*) as views from View WHERE auctionID=?";
        $args = array($auctionID);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) > 0) {
            return $result[0][0];
        } else {
            return 0;
        }
    }

    function get_past_aucs(){
        $current_time = current_time();
        $query = "SELECT Auction.auctionID, Auction.isbn, asking_price, starting_price, end_time,
            title, aLast, aFirst, book_condition, genre, publisher, language, date
                FROM (Auction join Book
                ON Auction.isbn = Book.isbn)
                WHERE auction.userID = ?
                AND auction.end_time <= ?";
        $args = array($_POST['userID'], $current_time);
        $result = run_query($query, 'ss', $args);
        if (is_array($result) && count($result) > 0) {
            for($i = 0; $i < count($result); $i++) {
                $count = get_views($result[$i][0]);
                array_push($result[$i], $count);
            }
            echo json_encode($result);
        } else {
            echo "No past auctions";
        }
    }

    function review() {
        $query = "SELECT *
                FROM reviews
                WHERE reviews.reviewerID = ?
                AND reviews.reviewedID = ?";
        $args = array($_SESSION['userID'], $_POST['reviewee']);
        $result = run_query($query, 'ss', $args);
        if (is_array($result)) {
            if (count($result) > 0)
                echo "You have already reviewed this user!";
            else
                submit_review();
        } else {
            echo "An error occurred!";
        }
    }

    function submit_review() {
        $query = "INSERT INTO reviews(reviewerID, reviewedID, review, rating)
                    VALUES (?, ?, ?, ?)";
        $args = array($_SESSION['userID'], $_POST['reviewee'], $_POST['content'], $_POST['rating']);
        $result = execute_change($query, 'ssss', $args);
         if (!is_string($result)) {
            echo 1;
        } else {
            echo "No past auctions";
        }
    }

    function get_rating() {
        $query = "SELECT AVG(rating)
                FROM reviews
                WHERE reviewedID =?";
        $args = array($_POST['userID']);
        $result = run_query($query, 's', $args);
        if (is_array($result) && count($result) > 0) {
            echo intval($result[0][0]);
        } else
            echo 0;
    }
?>
