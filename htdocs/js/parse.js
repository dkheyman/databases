function print_current_bids(results) {
    results = JSON.parse(results);
    var bid_div = document.createElement("div");
    bid_div.setAttribute("id", "current_bids");
    bid_div.setAttribute("class", "Table");
    for (i = 0; i < results.length; i++) {
        var new_row = document.createElement("div");
        new_row.setAttribute("class", "Row");
        new_row.setAttribute("id", "row" + i);
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 1 || j == 2) {
                results[i][j] = '$' + results[i][j];
            }
            elem.innerHTML = results[i][j];
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
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 1 || j == 2) {
                results[i][j] = '$' + results[i][j];
            }
            elem.innerHTML = results[i][j];
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('pastBids').appendChild(bid_div);
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
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 1 || j == 2) {
                results[i][j] = '$' + results[i][j];
            }
            elem.innerHTML = results[i][j];
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
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 1 || j == 2) {
                results[i][j] = '$' + results[i][j];
            }
            elem.innerHTML = results[i][j];
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
        for(j = 0; j < results[i].length; j++) {
            var elem = document.createElement("td");
            elem.setAttribute("class", "Cell");
            if (j == 1 || j == 2) {
                results[i][j] = '$' + results[i][j];
            }
            elem.innerHTML = results[i][j];
            new_row.appendChild(elem);
        }
        bid_div.appendChild(new_row);
    }
    document.getElementById('watches').appendChild(bid_div);
}
