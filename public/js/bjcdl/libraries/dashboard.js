// Utility function to get unique names
function getUniqueNames(odds, market_name) {
    var names = [];
    var uniqueNames = [];

    $.each(odds[market_name], function(_, odd) {
        if (odd.selection_points !== null) {
            names.push(odd.name);
        }
    });

    $.each(names, function(i, el){
        if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
    });

    return uniqueNames;
}


function getGames() {

    var currentDateISO8601 = moment().format('YYYY-MM-DDTHH:mm:ss');
    // console.log(currentDateISO8601);

    console.log('Loading...');
    $.ajax({
        url: sBaseURI + '/api/game-listing',
        // url: sBaseURI + '/public/oddsjam.js',
        method: 'GET',
        // dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            is_live: false,
            start_date_before: currentDateISO8601
        },
        _success: function (response) {

            var html = '';
            
            if (response.length > 0 ) {
                $.each(response, function (index, value) {

                    if (value.markets.length > 0 ) {
                        $.each(value.markets, function (i, val) {

                            const formattedDate = moment(value.game.start_date).format('MMMM D, YYYY - h:mm A');
                            
                            // console.log(value.home_team_odds);
                            // console.log(value.away_team_odds);

                            var home_odds = value.home_team_odds;
                            var away_odds = value.away_team_odds;

                            var market_name = val.label;

                            var selectionPoints1 = $.map(home_odds[market_name], function(odd) {
                                return odd.selection_points;
                            });
                            var selectionPoints2 = $.map(away_odds[market_name], function(odd) {
                                return odd.selection_points;
                            });

                            var homeOddsBooksSelectionPoint = selectionPoints1.length ? Math.max.apply(null, selectionPoints1) : 0;
                            var awayOddsBooksSelectionPoint = selectionPoints2.length ? Math.max.apply(null, selectionPoints2) : 0;

                            // Retrieve sports_book_name based on matching selection points and ensure uniqueness using Set
                            var homeOddsSportsBookNamesSet = new Set();
                            $.each(home_odds[market_name], function(_, odd) {
                                if (odd.selection_points === homeOddsBooksSelectionPoint) {
                                    homeOddsSportsBookNamesSet.add(odd.sports_book_name);
                                }
                            });

                            var awayOddsSportsBookNamesSet = new Set();
                            $.each(away_odds[market_name], function(_, odd) {
                                if (odd.selection_points === awayOddsBooksSelectionPoint) {
                                    awayOddsSportsBookNamesSet.add(odd.sports_book_name);
                                }
                            });

                            // Joining unique sports book names using comma and space
                            var homeOddsSportsBookName = [...homeOddsSportsBookNamesSet].join(', ');
                            var awayOddsSportsBookName = [...awayOddsSportsBookNamesSet].join(', ');


                            var homeBetName = "";
                            var awayBetName = "";

                            $.each(home_odds[market_name], function(_, odd) {
                                if (odd.selection_points === homeOddsBooksSelectionPoint) {
                                    homeBetName = odd.name;
                                    return false; // break out of the loop after the first match
                                }
                            });

                            $.each(away_odds[market_name], function(_, odd) {
                                if (odd.selection_points === awayOddsBooksSelectionPoint) {
                                    awayBetName = odd.name;
                                    return false; // break out of the loop after the first match
                                }
                            });

                            html += `<tr>
                                <th scope="row">--</th>
                                <td>${formattedDate}</td>
                                <td>
                                    <p>
                                        ${value.game.home_team} vs ${value.game.away_team} <br> <small>${value.game.league} |  ${value.game.sport}</small>
                                    </p>
                                </td>
                                <td>
                                    <p>${val.label}</p>
                                </td>
                                <td>
                                     <p>${homeBetName}</p>
                                    <hr>
                                    <p>${awayBetName}</p>
                                </td>
                                 <td>
                                    <p>
                                    <strong>${homeOddsBooksSelectionPoint}</strong> ${homeOddsSportsBookName}
                                    <hr>
                                    <strong>${awayOddsBooksSelectionPoint}</strong> ${awayOddsSportsBookName}</p>
                                </td>
                                <td>---</td>
                                <td>---</td>
                                <td>
                                
                                </td>
                            </tr>`;

                        });
                    }
                });

                $("#arbitrage_body").html(html);
            }

        },
        get success() {
            return this._success;
        },
        set success(value) {
            this._success = value;

        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

getGames();