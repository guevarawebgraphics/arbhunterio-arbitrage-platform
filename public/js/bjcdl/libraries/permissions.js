if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.permissions = {};

$.permissions.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        var table = $('#permissions-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},
            ]
        });


        $(document).on('click','.btn-delete',function(){
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data record.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                    var rowid = $(this).data('rowid');
                    var el = $(this);
                    if(!rowid) return;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {_method: 'DELETE', _token:token},
                        method: "POST",
                        dataType: 'JSON',
                        url: sAdminBaseURI + '/permissions/' + rowid +'/delete',
                        success: function (data) {
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                            Swal.fire(
                                'Deleted!',
                                'Data record has been deleted.',
                                'success'
                            );
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire(
                    'Cancelled',
                    'Delete process has been cancelled successfully',
                    'error'
                  );
                }
              });
        });
    }
}

$(function () {
    $.permissions.init.activate();
});
