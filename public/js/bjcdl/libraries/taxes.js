if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.taxes = {};

$.taxes.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        var table = $('#taxes-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'name', name: 'name'},
                {data: 'country', name: 'country'},
                {data: 'tax', name: 'tax'},
                {data: 'action', name: 'action'},
            ]
        });
    }
}

$(function () {
    $.taxes.init.activate();
});
