function getGames() {

    var currentDateISO8601 = moment().format('YYYY-MM-DDTHH:mm:ss');
    console.log(currentDateISO8601);
    $.ajax({
        url: sBaseURI + '/api/games',
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            is_live: false,
            start_date_after: currentDateISO8601
        },
        _success: function (response) {
            var html = '';


            if (response.status) {

                $.each(response.data, function (i, val) {
                    if (val.length > 0) {
                        $.each(val, function (index, value) {

                            const formattedDate = moment(value.start_date).format('MMMM D, YYYY - h:mm A');

                            html += `<tr>
                                <th scope="row">--</th>
                                <td>${formattedDate}</td>
                                <td>
                                    <p>
                                        ${value.home_team} vs ${value.away_team} | ${value.league}
                                    </p>
                                </td>
                                <td>
                                    --
                                </td>
                                <td>---</td>
                                <td>---</td>
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