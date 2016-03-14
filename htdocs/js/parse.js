function print_users_auctions(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "auction_list");
    bid_div.setAttribute("class", "Table");
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
            elem.innerHTML = results[i][j];
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
                var addr = "auction.php?auction_id=" + encodeURIComponent(results[i][0]);
                var inner = "<a href=" + addr + ">" + results[i][j] + "</a>";
                elem.innerHTML = inner;
            } else {
                elem.innerHTML = results[i][j];
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
    document.getElementById('pastBids').appendChild(bid_div);
}

function print_recommended(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "cur_auctions");
    bid_div.setAttribute("class", "Table");
    for (i = 0; i < /*results.length*/ 10; i++) {
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
    document.getElementById('recommended').appendChild(bid_div);
}

function print_current_auctions(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "cur_auctions");
    bid_div.setAttribute("class", "Table");
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
    document.getElementById('currAucs').appendChild(bid_div);
}

function print_past_auctions(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "past_auctions");
    bid_div.setAttribute("class", "Table");
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

function print_watches(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "watch_list");
    bid_div.setAttribute("class", "Table");
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
    document.getElementById('watches').appendChild(bid_div);
}

function print_books_with_radio(results) {
    results = JSON.parse(results);
    var book_div = document.createElement("div");
    book_div.setAttribute("id", "book_list");
    book_div.setAttribute("class", "Table");
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        var radio_btn = document.createElement("input");
        radio_btn.setAttribute("type", "Radio");
        radio_btn.setAttribute("name", "book_radio");
        radio_btn.setAttribute("id", "book_radio" + i);
        radio_btn.setAttribute("value", results[i][1]);
        new_row.appendChild(elem);
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            elem.innerHTML = results[i][j];
            new_row.appendChild(elem);
        }
        book_div.appendChild(new_row);
    }
    document.getElementById('book_list').appendChild(book_div);
}

function print_genres(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "genre_list");
    bid_div.setAttribute("class", "Table");
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        var elem = document.createElement("td");
        elem.setAttribute("class", "Cell");
        elem.innerHTML = "<a href=\"" + window.location.href + "?genre=" + results[i][0] + "\">" + results[i][0] + "</a>";
        new_row.appendChild(elem);
        bid_div.appendChild(new_row);
    }
    document.getElementById('genre_select').appendChild(bid_div);
}
