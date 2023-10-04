function getBetPoints(game, marketLabel) {
    let highestHomeBetPoints = null;
    let lowestAwayBetPoints = null;

    if (game && game.home_team_odds && game.home_team_odds[marketLabel]) {
        highestHomeBetPoints = Math.max(...game.home_team_odds[marketLabel].map(odd => odd.bet_points || 0));
    }

    if (game && game.away_team_odds && game.away_team_odds[marketLabel]) {
        lowestAwayBetPoints = Math.min(...game.away_team_odds[marketLabel].map(odd => odd.bet_points || 0));
    }

    return {
        home: highestHomeBetPoints,
        away: lowestAwayBetPoints
    };
}
function getSportsBookNames(game, marketLabel) {
    let homeSportsBooks = [];
    let awaySportsBooks = [];

    if (game && game.home_team_odds && game.home_team_odds[marketLabel]) {
        homeSportsBooks = [...new Set(game.home_team_odds[marketLabel].map(odd => odd.sports_book_name))].filter(Boolean);
    }

    if (game && game.away_team_odds && game.away_team_odds[marketLabel]) {
        awaySportsBooks = [...new Set(game.away_team_odds[marketLabel].map(odd => odd.sports_book_name))].filter(Boolean);
    }

    return {
        home: homeSportsBooks,
        away: awaySportsBooks
    };
}



function getGames() {

    var currentDateISO8601 = moment().format('YYYY-MM-DDTHH:mm:ss');
    // console.log(currentDateISO8601);

    console.log('Loading...');
    $.ajax({
        url: sBaseURI + '/api/game-listing',
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            is_live: false,
            start_date_after: currentDateISO8601
        },
        _success: function (response) {
            var html = '';
            
            if (response.length > 0 ) {
                $.each(response, function (index, value) {
                    if (value.markets.length > 0 ) {
                        $.each(value.markets, function (i, val) {
                            const formattedDate = moment(value.game.start_date).format('MMMM D, YYYY - h:mm A');

                            const betPointsForMarket = getBetPoints(value, val.label);
                            const highestBetPointForHome = betPointsForMarket.home;
                            const lowestBetPointForAway = betPointsForMarket.away;

                            const sportsBooks = getSportsBookNames(value, val.label);
                            const homeSportsBooksList = sportsBooks.home.join(', ');
                            const awaySportsBooksList = sportsBooks.away.join(', ');

                            html += `<tr>
                                <th scope="row">--</th>
                                <td>${formattedDate}</td>
                                <td>
                                    <p>
                                        ${value.game.home_team} vs ${value.game.away_team} | ${value.game.league} |  ${value.game.sport}
                                    </p>
                                </td>
                                <td>
                                    <p>${val.label}</p>
                                </td>ge
                                <td>
                                    <ul style="list-style-type:none;">
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </td>
                                 <td>
                                    <ul style="list-style-type:none;">
                                         <li>${highestBetPointForHome} | ${homeSportsBooksList}</li>
                                         <li>${lowestBetPointForAway} | ${awaySportsBooksList}</li>
                                    </ul>
                                </td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
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