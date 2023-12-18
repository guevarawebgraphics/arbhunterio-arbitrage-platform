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


    var gameId = $(this).attr('data-id');

    var betType = $(this).attr('data-bet_type');

    var slug = $(this).attr('data-slug');

    var slug_url = $(this).attr('data-slug-url');


    var $myDiv = $('#table--view-data-' + slug_url);
    if ($myDiv.css('display') === 'none') {
        $myDiv.css('display', 'block');
    } else {
        $myDiv.css('display', 'none');
    }
    
    $("#view-modal-body-over").html(' ');

    $("#view-modal-body-under").html(' ');

    $("#view-modal-body-over").addClass('placeholder-content');

    $("#view-modal-body-under").addClass('placeholder-content');


    $.ajax({
        url: baseURI + "/api/game" + "/" + gameId + "/bet_type/" + betType,
        method: 'GET',
        success: function (response) {
            


            $("#viewModal-title").html(response.game.home_team + ' vs ' + response.game.away_team);

            $("#viewModal-market").html(response.game.bet_type);

            $( '#' + slug ).html(`<svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"></path>
            </svg>`);
        
            console.log(response);

            if (response.odds.best_over_odds_query.length > 0) {

                
                var sportsbookA = response.game.sportsbook_a_values;
                var sportsbookB = response.game.sportsbook_b_values;
                
                var sportsbookAExplode = sportsbookA.split(',');
                var sportsbookBExplode = sportsbookB.split(',');

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
                
                $.each(response.odds.best_over_odds_query, function (index, value) {
                    
                    over_html += `<tr>`;
                    over_html += `<th>${value.sportsbook}</th>`;

                    if (response.game.best_odds_a == convertAmericanToDecimalOdds(value.max_bet_price) && response.game.selection_line_a == value.bet_name && sportsbookAExplode.includes(value.sportsbook) ) {
                        
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
                    if (response.game.best_odds_b == convertAmericanToDecimalOdds(value.max_bet_price) && response.game.selection_line_b == value.bet_name && sportsbookBExplode.includes(value.sportsbook) ) {
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

                var final_html = `<td colspan="9" class="text-center py-4">
                        <div class="grid grid-rows-2 grid-flow-col gap-4">
                            <div class="row-span-2">
                                <div class="p-6">
                                    <table>
                                        <tbody>
                                            ${over_html}
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row-span-2">
                                <div class="p-6">
                                    <table>
                                        <tbody>
                                            ${under_html}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </td>`;

               
                console.log(under_html);

                $("#view-modal-body-over").html(over_html);
                $("#view-modal-body-under").html(under_html);
            }


            console.log("#table--view-data-" + response.slug.bet_type + "-" + response.slug.game_id);

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
                refreshDataTable();
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

    var sportsbook = $('input[name="sportsbook[]"]:checked').length;

    var sports = $('input[name="sports[]"]:checked').length;

    var market = $('input[name="market[]"]:checked').length;

    var date_time = $('input[name="date_time[]"]:checked').length;

    var filter_item = $(".save--filter-items").length;

    var percentage = 0;

    $(".sportsbook-count").html(sportsbook);

    $(".sports-count").html(sports);

    $(".market-count").html(market);

    $(".datetime-count").html(date_time);

    $('input[name="percentage_value[]"]').each(function() {
        if ($(this).val()) {
            percentage++;
        }
    });
    $(".percentage-count").html(percentage);

    var total = sportsbook + sports + market + date_time + percentage;
    
    $(".total-filter").html(total);

      
    $(".saved-filters-count").html(filter_item);

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

$(document).on('click', '.btn--clear-all', function () {
    location.reload();
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

    let first_time = false;

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
        date_time: date_time,
        first_time:first_time
    });

    console.log(input);
    
    Livewire.emit('refreshTable', input[0]);

    filterCounts();

    
}

$(document).on('click', '.btn--save-filter', function () {

    Swal.fire({
        title: ``,
        html: `
      
            <div class="mb-5">
                <label for="name_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter name</label>
                <input type="text" id="name_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="NBA this week" required>
            </div>
            <div class="flex items-start mb-5">
                <div class="flex items-center h-5">
                <input id="is_alert" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required>
                </div>
                <label for="is_alert" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Recieve an instant email alert when there are new betting opportunities matching your filter criteria</label>
            </div>
        `,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `
            Submit
        `,
        confirmButtonAriaLabel: "Submit",
        cancelButtonText: `
           Cancel
        `,
        cancelButtonAriaLabel: "Cancel"
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
           
            let input = [];

            let first_time = false;

            let min_profit = 0;

            let max_profit = 0;

            min_profit = $("#minimum_profit_percentage").val() ?  $("#minimum_profit_percentage").val() : 0 ;

            max_profit = $("#maximum_profit_percentage").val() ? $("#maximum_profit_percentage").val() : 0;

            let sports = [];

            let sportsbook = [];

            let market = [];

            let date_time = 0;  // 0 = NONE; 1 = Today; 2 = Next 24 Hours

            var name_filter = $("#name_filter").val();

            var is_alert = $("#is_alert:checked").val();
            
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
                date_time: date_time,
                name_filter: name_filter,
                user_id: user_id,
                is_alert:is_alert
            });


            $.ajax({
                url: baseURI + "/api/save/filter",
                method: 'POST',
                data: {
                    min_profit: min_profit,
                    max_profit: max_profit,
                    sports: sports,
                    sportsbook: sportsbook,
                    market: market,
                    date_time: date_time,
                    name_filter: name_filter,
                    user_id:user_id
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: "Success",
                            text: "Successfully saved!",
                            icon: "success"
                        });

                        getFilters();
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong..",
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong..",
                        icon: "error"
                    });
                }
            });


        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
});

async function getFilters() {
    $.ajax({
        url: baseURI + "/api/filters/" + user_id,
        method: 'GET',
        success: function (response) {
            var html = '';

            if (response.length > 0 ) {
                
                $.each(response, function (i, val) {
                    html += `<div class="form-check save--filter-items">
                                <label class="flex flex-row items-center text-white">
                                <a href="javascript:void(0);" class="btn--filter-item" data-id="${val.id}">
                                     ${val.name} 
                                </a>
                                <a href="javascript:void(0);" class="btn--delete-save-filter" data-id="${val.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                    </svg>
                                </a>
                                </label>
                            </div>`;
                });
            }
            $("#save-filter-list").html(html);

            filterCounts();


        },
        error: function () {
            
        }
    });

}

getFilters();

$(document).on('click', '.btn--delete-save-filter', function () {

    var id = $(this).attr('data-id');
    $.ajax({
        url: baseURI + "/api/filter/delete/" + id,
        method: 'GET',
        success: function (response) {
            Swal.fire({
                title: "Success",
                text: "Successfully deleted!",
                icon: "success"
            });
            getFilters();
        },
        error: function () {
            
        }
    });

});

$(document).on('click', '.btn--filter-item', function () {

    var id = $(this).attr('data-id');
    $.ajax({
        url: baseURI + "/api/filter/" + id,
        method: 'GET',
        success: function (response) {
            console.log(response);
            if (response) {
                $("#minimum_profit_percentage").val(response.min_profit);
                $("#maximum_profit_percentage").val(response.max_profit);

                $(`input[name="sportsbook[]"]`).prop('checked', false);
                $(`input[name="sports[]"]`).prop('checked', false);
                $(`input[name="market[]"]`).prop('checked', false);
                 $(`input[name="date_time[]"]`).prop('checked', false);

                $.each(response.sportsbook, function (i, val) {
                    $(`input[name="sportsbook[]"][value="${val}"]`).prop('checked', true);
                });

                 $.each(response.sports, function (i, val) {
                    $(`input[name="sports[]"][value="${val}"]`).prop('checked', true);
                 });
                
                 $.each(response.markets, function (i, val) {
                    $(`input[name="market[]"][value="${val}"]`).prop('checked', true);
                 });
                
                $(`input[name="date_time[]"][value="${response.datetime}"]`).prop('checked', true);
                
                filterCounts();

                refreshDataTable();
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong..",
                    icon: "error"
                });
            }
        },
        error: function () {
            
        }
    });

});


