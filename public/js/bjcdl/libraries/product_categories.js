if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.product_categories = {};

$.product_categories.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var permissions = JSON.parse(window.permissions.split('\\'));
        
        var table = $('#product_categories-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
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
                        url: sAdminBaseURI + '/product_categories/' + rowid +'/delete',
                        success: function (data) {
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                            if (permissions.permission.find(perm => perm.name === 'Restore Product Category')) {
                                Swal.fire({
                                    title: 'Hey, you can undo this!',
                                    text: 'You may able to undo your deletion once. Click RECOVER to proceed, otherwise click ok',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Recover it',
                                    cancelButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            //run restoration ajax
                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: {_method: 'GET', _token:token},
                                                method: "GET",
                                                url: sAdminBaseURI + '/product_categories/' + rowid +'/restore',
                                                success: function (data) {
                                                    $('#product_categories-table').DataTable().ajax.reload();
                                                    Swal.fire(
                                                        'Restored!',
                                                        'Data record has been restored.',
                                                        'success'
                                                    );
                                                },
                                            })
                                            .fail(function(jqXHR){
                                                console.log(jqXHR);
                                                if(jqXHR.status == 500 || jqXHR.status==0){
                                                    Swal.fire(
                                                        'Access Restricted',
                                                        'You have no permission to restore',
                                                        'warning'
                                                    );
                                                }
                                            });
                                            
                                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                                            Swal.fire(
                                                'Deleted!',
                                                'Data record has been deleted.',
                                                'success'
                                            );
                                        }
                                })
                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    'Data record has been deleted.',
                                    'success'
                                );
                            }
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
    $.product_categories.init.activate();
});
