if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.newsletter = {};

$.newsletter.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        var table = $('#newsletters-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'}
            ]
        });
    }
}

$(function () {
    $.newsletter.init.activate();
});
