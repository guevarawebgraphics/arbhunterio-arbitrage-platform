if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.activity_logs = {};

$.activity_logs.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        var table = $('#activity_logs-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'log', name: 'log'},
            ]
        });
    }
}

$(function () {
    $.activity_logs.init.activate();
});
