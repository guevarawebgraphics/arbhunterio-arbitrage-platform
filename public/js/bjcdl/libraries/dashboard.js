var loading_html = `<tr>
    <!-- colspan is set to 9 since there are 9 columns in the table -->
    <td colspan="9" class="px-6 py-3 text-center">
    <center><img src="${sBaseURI}/public/images/loading2.gif" style="width: 25px; height: auto;" />
    Loading content..</center>
    </td>
</tr>`;

var no_record_found = `<tr>
    <!-- colspan is set to 9 since there are 9 columns in the table -->
    <td colspan="9" class="px-6 py-3 text-center">
    <center>No record found..</center>
    </td>
</tr>`;

function convertAmericanToDecimalOdds(americanOdds) {
    console.log(americanOdds); // This will log to the browser console

    var formula = 0.00;
    if (americanOdds > 0) {
        formula = 1 + (americanOdds / 100);
    } else if (americanOdds < 0) {
        formula = 1 - (100 / americanOdds);
    }

    // JavaScript's toFixed() method is similar to PHP's number_format function
    return formula.toFixed(2);
}
    
$(document).on('click', '.btn--view-modal', function () {
    

    $(this).html(`<svg width="20" height="20" fill="currentColor" class="mr-2 animate-spin" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
            <path d="M526 1394q0 53-37.5 90.5t-90.5 37.5q-52 0-90-38t-38-90q0-53 37.5-90.5t90.5-37.5 90.5 37.5 37.5 90.5zm498 206q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-704-704q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm1202 498q0 52-38 90t-90 38q-53 0-90.5-37.5t-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-964-996q0 66-47 113t-113 47-113-47-47-113 47-113 113-47 113 47 47 113zm1170 498q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-640-704q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm530 206q0 93-66 158.5t-158 65.5q-93 0-158.5-65.5t-65.5-158.5q0-92 65.5-158t158.5-66q92 0 158 66t66 158z">
            </path>
        </svg>`);

    var gameId = $(this).attr('data-id');

    var betType = $(this).attr('data-bet_type');

    var slug = $(this).attr('data-slug');
    
    $("#view-modal-body-over").html(' ');

    $("#view-modal-body-under").html(' ');

    $("#view-modal-body-over").addClass('placeholder-content');

    $("#view-modal-body-under").addClass('placeholder-content');

    $.ajax({
        url: baseURI + "/api/game" + "/" + gameId + "/bet_type/" + betType,
        method: 'GET',
        success: function(response) {

            $("#viewModal-title").html(response.game.home_team + ' vs ' + response.game.away_team);

            $("#viewModal-market").html(response.game.bet_type);

            $( '#' + slug ).html(`<svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"></path>
            </svg>`);
        
            console.log(response);

            if(response.odds.best_over_odds_query.length > 0 ) {

                var over_html = ``;

                over_html += `<tr>
                        <th></th>
                        <td>
                            <div class="p-6">
                    <div class="flex text-sm my-2">
                        <div class="flex-initial w-48">
                            <div class="flex flex-col text-center items-center justify-center">
                                <span class="font-bold">${response.game.selection_line_a}</span>
                            </div>
                        </div>
                    </div>
                    </td>
                </tr>`;
                
                $.each(response.odds.best_over_odds_query, function(index, value) {
                    over_html += `<tr>`;
                    over_html += `<th>${value.sportsbook}</th>`;
                    if (response.game.best_odds_a == convertAmericanToDecimalOdds(value.max_bet_price) && response.game.selection_line_a == value.bet_name  ) {
                        over_html += `<td><span style="background-color:green; color: #fff;" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">${value.max_bet_price}</span></td>`;
                        over_html += `<td></td>`;
                        over_html += `<td><span style="background-color:green; color: #fff;" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">${convertAmericanToDecimalOdds(value.max_bet_price)}</span></td>`;
                        over_html += `<td></td>`;
                        over_html += `<td><small>${value.bet_name}</small></td>`;
                    } else {
                        over_html += `<td><span style="background-color:#f3f4f6;" class="bg-gray-100 text-black text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">${value.max_bet_price}</span></td>`;
                        over_html += `<td></td>`;
                        over_html += `<td><span style="background-color:#f3f4f6;" class="bg-gray-100 text-black text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">${convertAmericanToDecimalOdds(value.max_bet_price)}</span></td>`;
                        over_html += `<td></td>`;
                        over_html += `<td><small>${value.bet_name}</small></td>`;
                    }
                    
                    over_html += `</tr>`;
                });

                var under_html = ``;

                under_html += `<tr>
                    <th></th>
                    <td>
                        <div class="p-6">
                <div class="flex text-sm my-2">
                    <div class="flex-initial w-48">
                        <div class="flex flex-col text-center items-center justify-center">
                            <span class="font-bold">${response.game.selection_line_b}</span>
                        </div>
                    </div>
                </div>
                </td>
                </tr>`;

                $.each(response.odds.best_under_odds_query, function(index, value) {
                    under_html += `<tr>`;
                    under_html += `<th>${value.sportsbook}</th>`;
                if (response.game.best_odds_b == convertAmericanToDecimalOdds(value.max_bet_price) && response.game.selection_line_b == value.bet_name ) {
                        under_html += `<td><span style="background-color:green; color: #fff;" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">${value.max_bet_price}</span></td>`;
                        under_html += `<td></td>`;
                        under_html += `<td><span style="background-color:green; color: #fff;" class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">${convertAmericanToDecimalOdds(value.max_bet_price)}</span></td>`;
                        under_html += `<td></td>`;
                        under_html += `<td><small>${value.bet_name}</small></td>`;
                    } else {
                        under_html += `<td><span style="background-color:#f3f4f6;" class="bg-gray-100 text-black text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">${value.max_bet_price}</span></td>`;
                        under_html += `<td></td>`;
                        under_html += `<td><span style="background-color:#f3f4f6;" class="bg-gray-100 text-black text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">${convertAmericanToDecimalOdds(value.max_bet_price)}</span></td>`;
                        under_html += `<td></td>`;
                        under_html += `<td><small>${value.bet_name}</small></td>`;
                    }
                    under_html += `</tr>`;
                });

                $("#view-modal-body-over").removeClass('placeholder-content');
                $("#view-modal-body-under").removeClass('placeholder-content');

                $("#view-modal-body-over").html(over_html);
                $("#view-modal-body-under").html(under_html);
            }

        },
        error: function() {

        }
    });

});

$(document).on('click','.btn--hidden-bet', function () {
    var gameId = $(this).attr('data-id');

    var betType = $(this).attr('data-bet_type');

    var slug = $(this).attr('data-slug');

    var status = $(this).attr('data-is_hidden');

    $.ajax({
        url: baseURI + "/api/game" + "/" + gameId + "/hidden/" + betType + "/status/" + status,
        method: 'GET',
        success: function(response) {
            if (response.status) {
                Livewire.emit('refreshTable', is_live, is_hidden);
                toastr.success('Successfully updated!');
            } else {
                // alert('Something went wrong..');
                toastr.error('Something went wrong..');
            }
        },
        error: function() {
            toastr.error('Something went wrong..');
        }
    });

});

async function filterCounts() {
    $(".sportsbook-count").html($('input[name="sportsbook[]"]:checked').length);

    $(".sports-count").html($('input[name="sports[]"]:checked').length);

    $(".market-count").html($('input[name="market[]"]:checked').length);

    $(".datetime-count").html($('input[name="date_time[]"]:checked').length);


    var count = 0;
    $('input[name="percentage_value[]"]').each(function() {
        if ($(this).val()) {
            count++;
        }
    });
    $(".percentage-count").html(count);
}

$(document).on('change keyup', '#minimum_profit_percentage, #maximum_profit_percentage', function () {
    refreshDataTable();
});

$(document).on('change keyup', 'input[name="sports[]"], input[name="sportsbook[]"], input[name="market[]"], input[name="date_time[]"]', function () {
    refreshDataTable();
});

$(document).on('click', '.btn--clear-profit', function () {
    $("#minimum_profit_percentage").val('');
    $("#maximum_profit_percentage").val('');
    refreshDataTable();
    filterCounts();
});

$(document).on('click', '.btn--clear-datetime', function () {
    $('input[name="date_time[]"]').prop('checked', false);
    refreshDataTable();
    filterCounts();
});


$(document).on('click', '.btn--toggle-select-sportsbook', function () {
    if(this.checked) {
        // If the toggle is checked, check all checkboxes
        $('input[name="sportsbook[]"]').prop('checked', true);
    } else {
        // If the toggle is unchecked, uncheck all checkboxes
        $('input[name="sportsbook[]"]').prop('checked', false);
    }
    refreshDataTable();
});

$(document).on('click', '.btn--toggle-select-sports', function () {
    if(this.checked) {
        // If the toggle is checked, check all checkboxes
        $('input[name="sports[]"]').prop('checked', true);
    } else {
        // If the toggle is unchecked, uncheck all checkboxes
        $('input[name="sports[]"]').prop('checked', false);
    }
    refreshDataTable();
});


$(document).on('click', '.btn--toggle-select-market', function () {
    if(this.checked) {
        // If the toggle is checked, check all checkboxes
        $('input[name="market[]"]').prop('checked', true);
    } else {
        // If the toggle is unchecked, uncheck all checkboxes
        $('input[name="market[]"]').prop('checked', false);
    }
    refreshDataTable();
});

filterCounts();

async function refreshDataTable() {

    let input = [];

    let min_profit = 0;

    let max_profit = 0;

    min_profit = $("#minimum_profit_percentage").val() ?  $("#minimum_profit_percentage").val() : 0 ;

    max_profit = $("#maximum_profit_percentage").val() ? $("#maximum_profit_percentage").val() : 0;

    let sports = [];

    let sportsbook = [];

    let market = [];

    let date_time = 0;  // 0 = NONE; 1 = Today; 2 = Next 24 Hours
    
    $('input[name="sports[]"]:checked').each(function() {
        sports.push($(this).val());
    });

    $('input[name="sportsbook[]"]:checked').each(function() {
        sportsbook.push($(this).val());
    });

    $('input[name="market[]"]:checked').each(function() {
        market.push($(this).val());
    });

    if ($('input[name="date_time[]"]:checked').val()) {
        date_time = $('input[name="date_time[]"]:checked').val();
    }

    input.push({
        min_profit: min_profit,
        max_profit: max_profit,
        sports: sports,
        sportsbook: sportsbook,
        market: market,
        date_time: date_time
    });

    console.log(input);
    
    Livewire.emit('refreshTable', input[0]);

    filterCounts();

    
}