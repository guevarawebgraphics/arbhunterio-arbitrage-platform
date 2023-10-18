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

function contains(arr, sportsBookName) {
    return arr.some(function (item) {
        return item === sportsBookName;
    });
}
function sports_book_image(arr, sports_book) {
    var imagesHTML = '';
    if (arr.length > 0 ) {
        $.each(arr, function (i, name) {
            if ( name != '' ) {
                var book = sports_book.find(function(item) {
                    return item.name === name;
                });
                if (book) {
                    imagesHTML += `<img class="rounded" width="24" src="${sBaseURI}/${book.image_url}" />`;
                }
                // console.log(imagesHTML);
            }
        });
    }
    return imagesHTML;
}
function calculateProfit(oddsA, oddsB) {
    // ( 1 - (1/2.5 + 1/2.5) * 100
    // = 0.4 + 0.4
    // = 1 - 0.8
    // = 0.2
    // = 0.2 * 100
    // = 20

    // Get the input values
    var odds1 = parseFloat(oddsA);
    var odds2 = parseFloat(oddsB);
    
    // Calculate the profit percentage
    var profitPercentage = (1 - (1/odds1 + 1/odds2)) * 100;

    // Display the result
    return Math.abs(profitPercentage.toFixed(2));
}
function findMatchingBets(dataObj1, dataObj2, type) {

    // 1 = Over and Under
    // 2 = Non Over and Under

    if (type == 1) {

        // Convert the object to an array.
        const dataArray = Object.values(dataObj1);
        
        const overs = dataArray.filter(item => item.selection_line === "over");
        const unders = dataArray.filter(item => item.selection_line === "under");

        let matchingPairs = [];

        for (const over of overs) {
            for (const under of unders) {
                if (Math.abs(over.selection_points) === Math.abs(under.selection_points)) {
                    matchingPairs.push({ over, under });
                }
            }
        }

        if (matchingPairs.length === 0) {
            return null;
        }

        const highestSelectionPoint = Math.max(...matchingPairs.map(pair => Math.abs(pair.over.selection_points)));

        const highestPair = matchingPairs.find(pair => Math.abs(pair.over.selection_points) === highestSelectionPoint);

        return highestPair;
    } else if (type == 2 && ( dataObj1 && dataObj2 ) ) {

        // Convert the object to an array.
        const dataArray1 = Object.values(dataObj1);
        const dataArray2 = Object.values(dataObj2);
        
        const homes = dataArray1.filter(item =>  ( item.selection_line != "over" && item.selection_line != "under" ) );
        const aways = dataArray2.filter(item => ( item.selection_line != "over" && item.selection_line != "under" ) );

        let matchingPairs = [];

        // for (const home of homes) {
        //     for (const away of aways) {
        //         // if (Math.abs(home.selection_points) === Math.abs(away.selection_points)) {
        //         if (Math.abs(home.selection_points) === Math.abs(away.selection_points) && home.selection_points !== away.selection_points) {
        //             matchingPairs.push({ home, away });
        //         }
        //     }
        // }

        for (const home of homes) {
            let matched = false; // Flag to check if a match has been found

            // First, prioritize positive numbers in home
            if (home.selection_points > 0) {
                for (const away of aways) {
                    if (home.selection_points === -away.selection_points) {
                        matchingPairs.push({ home, away });
                        matched = true;
                        break;
                    }
                }
            }
            
            // If no positive home was matched, then check for a negative home
            if (!matched && home.selection_points < 0) {
                for (const away of aways) {
                    if (-home.selection_points === away.selection_points) {
                        matchingPairs.push({ home, away });
                        break;
                    }
                }
            }
        }

        if (matchingPairs.length === 0) {
            return null;
        }

        const highestSelectionPoint = Math.max(...matchingPairs.map(pair => Math.abs(pair.home.selection_points)));

        const highestPair = matchingPairs.find(pair => Math.abs(pair.home.selection_points) === highestSelectionPoint);

        return highestPair;
    }

}
function getGames() {

    var currentDateISO8601 = moment().format('YYYY-MM-DDTHH:mm:ss');
    // console.log(currentDateISO8601);

    console.log('Loading...');
    $.ajax({
        url: sBaseURI + '/api/games',
        method: 'GET',
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

                            // const formattedDate = moment(value.game.start_date).format('MMMM D, YYYY - h:mm A');
                            const formattedDate = moment(value.game.start_date).format('ddd, MMM D [at] h:mm A');

                            var home_odds = value.home_team_odds;
                            var away_odds = value.away_team_odds;
                            var market_name = val.label;

                            // Over and Under Variables
                            var over_best_odds = 0;
                            var under_best_odds = 0;
                            var over_selection_line = '';
                            var under_selection_line = '';
                            var over_sports_books = [];
                            var under_sports_books = [];

                            // NON - Over and Under Variables
                            var home_best_odds = 0;
                            var away_best_odds = 0;
                            var home_selection_line = '';
                            var away_selection_line = '';
                            var home_sports_books = [];
                            var away_sports_books = [];


                            // Over and Under Odds
                            var mergedOdds = Object.assign({}, home_odds[market_name], away_odds[market_name]);
                            $.each(mergedOdds, function (index, obj) {
                                if (obj.selection_line === 'over' && obj.bet_points >= over_best_odds && obj.is_live == false ) {
                                    if (obj.bet_points > over_best_odds) {
                                        over_best_odds = obj.bet_points;
                                        over_sports_books = [obj.sports_book_name];
                                    } else if (!contains(over_sports_books, obj.sports_book_name)) {
                                        over_sports_books.push(obj.sports_book_name);
                                    }
                                }
                                if (obj.selection_line === 'under' && obj.bet_points >= under_best_odds && obj.is_live == false) {
                                    if (obj.bet_points > under_best_odds) {
                                        under_best_odds = obj.bet_points;
                                        under_sports_books = [obj.sports_book_name];
                                    } else if (!contains(under_sports_books, obj.sports_book_name)) {
                                        under_sports_books.push(obj.sports_book_name);
                                    }
                                }
                            });
                            
                            var found_matched_over_under = findMatchingBets(mergedOdds, null, 1);
                            over_selection_line = found_matched_over_under?.over?.name;
                            under_selection_line = found_matched_over_under?.under?.name;
                            
                            // Sports Book Dynamic Images
                            var over_sports_book_images = sports_book_image(over_sports_books, sports_book);
                            var under_sports_book_images = sports_book_image(under_sports_books, sports_book);

                            // Retrieval of Home and Away Odds
                            $.each(home_odds[market_name], function (index, obj) {
                                if ( !obj.selection_line || ( obj.selection_line != 'over' && obj.selection_line != 'under' ) ) {
                                    if (obj.bet_points > home_best_odds) {
                                        home_best_odds = obj.bet_points;
                                        home_sports_books = [obj.sports_book_name];
                                    } else if (!contains(home_sports_books, obj.sports_book_name)) {
                                        home_sports_books.push(obj.sports_book_name);
                                    }
                                }
                            });

                            $.each(away_odds[market_name], function (index, obj) {
                                if ( !obj.selection_line || ( obj.selection_line != 'over' && obj.selection_line != 'under' ) ) {
                                    if (obj.bet_points > away_best_odds) {
                                        away_best_odds = obj.bet_points;
                                        away_sports_books = [obj.sports_book_name];
                                    } else if (!contains(away_sports_books, obj.sports_book_name)) {
                                        away_sports_books.push(obj.sports_book_name);
                                    }
                                }
                            });

                            var home_away_found_matched_over_under = findMatchingBets(home_odds[market_name], away_odds[market_name], 2);

                            home_selection_line = home_away_found_matched_over_under?.home?.name;
                            away_selection_line = home_away_found_matched_over_under?.away?.name;
                            

                            // Sports Book Dynamic Images
                            var home_sports_book_images = sports_book_image(home_sports_books, sports_book);
                            var away_sports_book_images = sports_book_image(away_sports_books, sports_book);



                            var is_html = '0';
                            // Must be greater than 0 and Over and Under Best Odds must be multiply to 4 and result must be greater than or equal to 4
                            if (over_best_odds > 0 && under_best_odds > 0 && ( (over_best_odds * under_best_odds) >= 4 ) && over_selection_line && under_selection_line  ) {
                                is_html = '1';
                            } else if ( home_best_odds > 0 && away_best_odds > 0 &&  ( (home_best_odds * away_best_odds) >= 4 ) && home_selection_line && away_selection_line ) {
                                is_html = '2';
                            }

                            if ( is_html != "0" ) {
                                var profit_percentage = is_html == 1 ? calculateProfit(over_best_odds, under_best_odds) : calculateProfit(home_best_odds, away_best_odds);

                                html += `<tr class="border-b hover:bg-[#1D2F41]">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <button data-modal-target="calculatorModal" data-modal-toggle="calculatorModal" class="bg-transparent outline-none" type="button" data-id="${value.game.id}">
                                                <svg width="19" height="19" class="h-5 w-5 text-brand-purple" viewBox="0 0 14 20" fill="#B386D6" xmlns="http://www.w3.org/2000/svg"><path d="M1.39645 0.736376C0.961223 0.830673 0.685581 0.975748 0.428075 1.25139C0.239478 1.45449 0.141553 1.62495 0.058135 1.90785C0.00735898 2.08919 0.000105268 2.84721 0.000105268 9.99937C0.000105268 18.5769 -0.0107753 18.0329 0.188702 18.4282C0.355537 18.7582 0.798014 19.11 1.17883 19.2152C1.45085 19.2914 12.549 19.2914 12.821 19.2152C13.2019 19.11 13.6443 18.7582 13.8112 18.4282C14.0107 18.0329 13.9998 18.5769 13.9998 9.99937C13.9998 1.42548 14.0107 1.96588 13.8112 1.57418C13.6552 1.26227 13.249 0.924971 12.8827 0.794405C12.7268 0.740002 12.2371 0.732748 7.09061 0.729122C4.00053 0.725494 1.43634 0.729122 1.39645 0.736376ZM11.6423 3.51818C11.7112 3.54356 11.8019 3.6161 11.8491 3.68501C11.9288 3.8047 11.9325 3.83008 11.9325 4.74768C11.9325 5.57098 11.9252 5.70517 11.8708 5.79584C11.7366 6.02071 12.0159 6.00983 7.07248 6.00983C2.12907 6.00983 2.40834 6.02071 2.27415 5.79584C2.21974 5.70517 2.21249 5.57098 2.21249 4.74768C2.21249 3.83008 2.21612 3.8047 2.29591 3.68501C2.34306 3.6161 2.43373 3.54356 2.50264 3.51818C2.68398 3.45652 11.461 3.45652 11.6423 3.51818ZM3.9026 8.13517C4.1311 8.302 4.15286 8.36728 4.16374 8.89318C4.17462 9.31752 4.16737 9.39731 4.10208 9.54239C3.97514 9.82891 3.9026 9.8543 3.1192 9.8543C2.36844 9.8543 2.28865 9.83253 2.13995 9.59316C2.07104 9.48436 2.06741 9.4227 2.07467 8.92219C2.08555 8.30925 2.11094 8.24397 2.35756 8.10615C2.47 8.04449 2.55341 8.04087 3.14459 8.04812C3.74302 8.059 3.81193 8.06625 3.9026 8.13517ZM7.76158 8.1134C8.00095 8.23672 8.05173 8.38179 8.05173 8.95483C8.05173 9.50249 8.01184 9.62943 7.80148 9.77088C7.68542 9.85067 7.64552 9.8543 6.99994 9.8543C6.35436 9.8543 6.31447 9.85067 6.19841 9.77088C5.98805 9.62943 5.94815 9.50249 5.94815 8.95483C5.94815 8.38904 5.99893 8.23672 6.23105 8.11703C6.35073 8.05175 6.44141 8.04449 6.99269 8.04087C7.55122 8.04087 7.63464 8.04812 7.76158 8.1134ZM11.6423 8.10978C11.8889 8.24034 11.9143 8.30925 11.9252 8.92219C11.9325 9.4227 11.9288 9.48436 11.8599 9.59316C11.7112 9.83253 11.6314 9.8543 10.8807 9.8543C10.2714 9.8543 10.1988 9.84704 10.09 9.78176C9.89055 9.65845 9.82889 9.47348 9.82889 8.95846C9.82889 8.49422 9.85428 8.36728 9.98485 8.22584C10.1335 8.06625 10.2424 8.04449 10.8988 8.04087C11.432 8.04087 11.5335 8.05175 11.6423 8.10978ZM3.90986 11.6315C4.12384 11.762 4.17825 11.9542 4.16374 12.52C4.15286 13.0568 4.12747 13.1221 3.88084 13.2889C3.76841 13.3687 3.72489 13.3723 3.12283 13.3723C2.41922 13.3723 2.31041 13.347 2.16171 13.1439C2.0928 13.0532 2.08555 12.9806 2.07467 12.491C2.06741 11.9905 2.07104 11.9289 2.13995 11.8201C2.28865 11.5807 2.36844 11.5589 3.1192 11.5589C3.72852 11.5589 3.80105 11.5662 3.90986 11.6315ZM7.80148 11.6423C8.01184 11.7838 8.05173 11.9107 8.05173 12.4656C8.05173 12.9045 8.04085 12.9698 7.96831 13.0967C7.82687 13.3433 7.72894 13.3723 6.99994 13.3723C6.27094 13.3723 6.17302 13.3433 6.03157 13.0967C5.95903 12.9698 5.94815 12.9045 5.94815 12.4656C5.94815 11.9107 5.98805 11.7838 6.19841 11.6423C6.31447 11.5625 6.35436 11.5589 6.99994 11.5589C7.64552 11.5589 7.68542 11.5625 7.80148 11.6423ZM11.6713 11.6315C11.9071 11.7765 11.9361 11.8745 11.9252 12.491C11.9143 12.9806 11.9071 13.0532 11.8382 13.1439C11.6895 13.347 11.5807 13.3723 10.8771 13.3723C10.275 13.3723 10.2315 13.3687 10.119 13.2889C9.87241 13.1221 9.84702 13.0568 9.83614 12.52C9.82526 12.0957 9.83252 12.0159 9.8978 11.8708C10.0247 11.5843 10.0973 11.5589 10.8807 11.5589C11.4864 11.5589 11.5625 11.5662 11.6713 11.6315ZM3.9026 15.135C4.1311 15.3055 4.15286 15.3635 4.16374 15.9075C4.17825 16.4878 4.1456 16.6039 3.93162 16.7671L3.79743 16.8723H3.12283C2.38658 16.8723 2.31767 16.8578 2.15809 16.6438C2.0928 16.5567 2.08555 16.4806 2.07467 16.0018C2.06379 15.3635 2.09643 15.2619 2.36119 15.1205C2.51352 15.0407 2.54979 15.0371 3.16273 15.048C3.74302 15.0588 3.81193 15.0661 3.9026 15.135ZM11.6423 15.1241C11.9035 15.2619 11.9361 15.3635 11.9252 16.0018C11.9143 16.6003 11.8926 16.6655 11.6605 16.807C11.5589 16.8686 11.4102 16.8723 8.93306 16.8723C6.34711 16.8723 6.31447 16.8723 6.21654 16.7961C5.99167 16.6293 5.96629 16.5604 5.95541 16.0671C5.94815 15.8168 5.95178 15.5557 5.96629 15.4868C5.9953 15.3309 6.17664 15.1241 6.32535 15.0806C6.387 15.0625 7.55848 15.0443 8.96207 15.0443L11.4864 15.0407L11.6423 15.1241Z" fill="#    B386D6"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        ${profit_percentage}%
                                    </td>
                                    <td class="px-6 py-4">
                                        ${formattedDate}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${value.game.home_team} vs ${value.game.away_team}
                                        <div class="flex flex-row gap-2">
                                            <span>${value.game.sport}</span>
                                            <span class="border-e"></span>
                                            <span>${value.game.league} </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        ${val.label}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span>
                                                ${is_html == 1 ? over_selection_line : home_selection_line }
                                            </span>
                                            <span>
                                                ${is_html == 1 ? under_selection_line : away_selection_line }
                                            </span>
                                        </div>
                                    </td>
                                     <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="flex flex-row items-center gap-2">
                                                <span>${ is_html == 1 ? over_best_odds : home_best_odds }</span>
                                            </div>
                                            <div class="flex flex-row items-center gap-2">
                                                <span>${ is_html == 1 ? under_best_odds : away_best_odds }</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="flex flex-row items-center gap-2">
                                                ${ is_html == 1 ? over_sports_book_images : home_sports_book_images}
                                            </div>
                                            <div class="flex flex-row items-center gap-2">
                                                ${ is_html == 1 ? under_sports_book_images : away_sports_book_images}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        ----
                                    </td>
                                </tr>`;
                            }
                            
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
