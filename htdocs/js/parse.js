function print_users_auctions(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "auction_list");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(printHeaderSellerAuction());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 0) {
                results[i][j] = '$' + results[i][j];
            }
            if (j == results[i].length - 1) {
                var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][j]);
                var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                elem.innerHTML = inner;
            } else {
                elem.innerHTML = results[i][j];
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('user_auctions').appendChild(bid_div);
}

function print_current_bids(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "current_bids");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(createHeaderUserAuctions());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 4) {
                var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][4]);
                var inner = "<a href=" + addr + ">" + results[i][4] + "</a>";
                elem.innerHTML = inner;
                console.log(elem);
            } else {
                if (j == 2 || j == 3) {
                    results[i][j] = '$' + results[i][j];
                }
                if (j == 1) {
                    var addr = "auction.php?auction_id=" + encodeURIComponent(results[i][0]);
                    var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    elem.innerHTML = results[i][j];
                }
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('currBids').appendChild(bid_div);
}

function print_past_bids(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "past_bids");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(createHeaderUserAuctions());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 4) {
                var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][4]);
                var inner = "<a href=" + addr + ">" + results[i][4] + "</a>";
                elem.innerHTML = inner;
            } else {
                if (j == 2 || j == 3) {
                    results[i][j] = '$' + results[i][j];
                }
                if (j == 1) {
                    var addr = "auction.php?auction_id=" + results[i][0];
                    var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    elem.innerHTML = results[i][j];
                }
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('pastBids').appendChild(bid_div);
}

function print_recommended(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "cur_auctions");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(createHeaderUserAuctions());
    for (i = 0; i < /*results.length*/ 10; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 4) {
                var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][4]);
                var inner = "<a href=" + addr + ">" + results[i][4] + "</a>";
                elem.innerHTML = inner;
            } else {
                if (j == 2 || j == 3) {
                    results[i][j] = '$' + results[i][j];
                }
                if (j == 1) {
                    var addr = "auction.php?auction_id=" + results[i][0];
                    var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    elem.innerHTML = results[i][j];
                }
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('recommended').appendChild(bid_div);
}

function createHeaderUserAuctions() {
    var new_row = document.createElement("div");
    new_row.setAttribute("class", "Row");
    new_row.setAttribute("id", "headerRow");

    var l= ["ISBN","Current Price", "Bid Value", "Seller", "End Time"];
    for (i = 0; i < l.length; i++) {
        var elem = document.createElement("td");
        elem.setAttribute("class", "Cell");
        elem.innerHTML = l[i];
        new_row.appendChild(elem);
    }
}

function print_current_auctions(results, type) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "cur_auctions");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(printHeaderSellerAuction());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (type == 'with_id') {
                if (j == 1) {
                    var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][1]);
                    var inner = "<a href=" + addr + ">" + results[i][1] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    if (j == 3 || j == 4) {
                        results[i][j] = '$' + results[i][j];
                    }
                    if (j == 2) {
                        var addr = "auction.php?auction_id=" + results[i][0];
                        var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                        elem.innerHTML = inner;
                    } else {
                        elem.innerHTML = results[i][j];
                    }
                }
            } else {
                if (j == 2 || j == 3) {
                    results[i][j] = '$' + results[i][j];
                }
                if (j == 1) {
                    var addr = "auction.php?auction_id=" + results[i][0];
                    var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    elem.innerHTML = results[i][j];
                }
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('currAucs').appendChild(bid_div);
}

function print_past_auctions(results, type) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "past_auctions");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(printHeaderSellerAuction());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 2 || j == 3) {
                results[i][j] = '$' + results[i][j];
            }
            if (j == 1) {
                var addr = "auction.php?auction_id=" + results[i][0];
                var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                elem.innerHTML = inner;
            } else {
                elem.innerHTML = results[i][j];
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('pastAucs').appendChild(bid_div);
}

function printHeaderSellerAuction() {
    var new_row = document.createElement("div");
    new_row.setAttribute("class", "Row");
    new_row.setAttribute("id", "headerRow");

    var l= ["ISBN","Current Price", "Starting Price", "End Time", "Book Title",
            "Author Surname", "Author First Name", "Condition", "Genre", "Publisher", "Language", ""];
    for (i = 0; i < l.length; i++) {
        var elem = document.createElement("td");
        elem.setAttribute("class", "Cell");
        elem.innerHTML = l[i];
        new_row.appendChild(elem);
    }
}

function print_watches(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "watch_list");
    bid_div.setAttribute("class", "Table");
    bid_div.appendChild(createHeaderUserAuctions());
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 1; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 4) {
                var addr = "seller_profile.php?seller_id=" + encodeURIComponent(results[i][4]);
                var inner = "<a href=" + addr + ">" + results[i][4] + "</a>";
                elem.innerHTML = inner;
            } else {
                if (j == 2 || j == 3) {
                    results[i][j] = '$' + results[i][j];
                }
                if (j == 1) {
                    var addr = "auction.php?auction_id=" + results[i][0];
                    var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                    elem.innerHTML = inner;
                } else {
                    elem.innerHTML = results[i][j];
                }
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('watches').appendChild(bid_div);
}

function print_bids(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("class", "Table");
    bid_div.setAttribute("id", "currBids");
    bid_div.appendChild(printHeaderBid());
    for(i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("tr");
            elem.setAttribute("class", "Cell");
            if (j == 0) {
                var addr = "buyer_profile.php?buyer_id=" + encodeURIComponent(results[i][0]);
                var inner = "<a href=" + addr + ">" + results[i][0] + "</a>";
                elem.innerHTML = inner;
            } else {
                if (j == 1) {
                    results[i][j] = '$' + results[i][j];
                }
                elem.innerHTML = results[i][j];
            }
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('currBids').appendChild(bid_div);
}

function printHeaderBid() {
    var new_row = document.createElement("div");
    new_row.setAttribute("class", "Row");
    new_row.setAttribute("id", "headerRow");

    var l= ["Buyer","Amount"];
    for (i = 0; i < l.length; i++) {
        var elem = document.createElement("td");
        elem.setAttribute("class", "Cell");
        elem.innerHTML = l[i];
        new_row.appendChild(elem);
    }
}

function print_books_with_radio(results) {
    results = JSON.parse(results);
    var book_div = document.createElement("select");
    book_div.setAttribute("id", "book_name");
    book_div.setAttribute("class", "Row");
    for(j = 0; j < results[0].length; j++) {
        var book = document.createElement("option");
        book.setAttribute("name", "book" + j);
        book.setAttribute("id", "book");
        book.setAttribute("value", results[j][1]);
        book.innerHTML = "ISBN: " + results[j][1] + "\t\tTitle: " + results[j][0];
        book_div.appendChild(book);
    }
    document.getElementById('book_list').appendChild(book_div);
}

function print_genres(results, category) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "genre_list");
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("tr");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        var elem = document.createElement("input");
        if (results[i][0] == category) {
            elem.setAttribute("checked", "true");
        }
        elem.setAttribute("type", "radio");
        elem.setAttribute("name", "genre");
        elem.setAttribute("id", "genre");
        elem.setAttribute("value", results[i][0]);
        elem.setAttribute("onClick", "javascript:update_browser()");
        var trial = document.createElement("label");
        trial.innerHTML = results[i][0];
        trial.setAttribute("for", "genre");
        new_row.appendChild(elem);
        new_row.appendChild(trial);
        bid_div.appendChild(new_row);
    }
    document.getElementById('genre_select').appendChild(bid_div);
}
