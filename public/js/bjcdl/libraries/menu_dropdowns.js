if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

$.menu_dropdown = {};

$.menu_dropdown.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var permissions = JSON.parse(window.permissions.split('\\'));
        
        var table = $('#menu_dropdown-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'parent_menu', name: 'parent_menu'},
                {data: 'name', name: 'name'},
                {data: 'order_number', name: 'order_number'},
                {data: 'is_active', name: 'is_active'},
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
                        url: sAdminBaseURI + '/dropdown_menu/' + rowid +'/delete',
                        success: function (data) {
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                            if (permissions.permission.find(perm => perm.name === 'Restore Menu Dropdown')) {
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
                                                url: sAdminBaseURI + '/dropdown_menu/' + rowid +'/restore',
                                                success: function (data) {
                                                    $('#menu_dropdown-table').DataTable().ajax.reload();
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
    },
    create: function () {
        $('#link').hide();
        $(document).on('click','#is_page',function(){
            if (!$(this).is(':checked')) {
                $('#link').show();
                $('#page').hide();
            } else {
                $('#link').hide();
                $('#page').show();
            }
        });
    },
    edit: function () {
        if (window.is_page == "0") {
            $('#link').show();
            $('#page').hide();
        } else {
            $('#link').hide();
            $('#page').show();
        }

        $(document).on('click','#is_page',function(){
            if (!$(this).is(':checked')) {
                $('#link').show();
                $('#page').hide();
            } else {
                $('#link').hide();
                $('#page').show();
            }
        });
    }
}

$(function () {
    const url = $(location).attr('pathname');
    const path = url.split('/');
    const page = path[path.length - 1];
    if (page == 'dropdown_menu') {
        $.menu_dropdown.init.activate();
    } else if (page == 'create') {
        $.menu_dropdown.init.create();
    } else if (page == 'edit') {
        $.menu_dropdown.init.edit();
    }
});
