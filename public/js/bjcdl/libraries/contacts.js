if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.contact = {};

$.contact.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        var table = $('#contacts-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action'}
            ]
        });
    }
}

$(function () {
    $.contact.init.activate();
});
