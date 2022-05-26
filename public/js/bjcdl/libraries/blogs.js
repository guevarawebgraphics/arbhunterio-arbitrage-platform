if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

var fetchImg = '';

$.blogs = {};

$.blogs.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var permissions = JSON.parse(window.permissions.split('\\'));

        var table = $('#blogs-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'author', name: 'author'},
                {data: 'created_at', name: 'created_at'},
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
                        url: sAdminBaseURI + '/blogs/' + rowid +'/delete',
                        success: function (data) {
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                            if (permissions.permission.find(perm => perm.name === 'Restore User')) {
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
                                                url: sAdminBaseURI + '/blogs/' + rowid +'/restore',
                                                success: function (data) {
                                                    $('#blogs-table').DataTable().ajax.reload();
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
    slugify: function (string) {
        return string
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
    },
    create: function () {
        $(document).on('click', '#close-preview', function(){ 
            $('.image-preview').popover('hide');
            // Hover befor close the preview
            $('.image-preview').hover(
                function () {
                   $('.image-preview').popover('show');
                }, 
                 function () {
                   $('.image-preview').popover('hide');
                }
            );    
        });

        $(document).on('click', '#close-preview-cover_image', function(){ 
            $('.cover_image-preview').popover('hide');
            // Hover befor close the preview
            $('.cover_image-preview').hover(
                function () {
                   $('.cover_image-preview').popover('show');
                }, 
                 function () {
                   $('.cover_image-preview').popover('hide');
                }
            );    
        });

        $(function() {
            // Create the close button
            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview',
                style: 'font-size: initial;',
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.image-preview-clear').click(function(){
                $('.image-preview').attr("data-content","").popover('hide');
                $('.image-preview-filename').val("");
                $('.image-preview-clear').hide();
                $('.image-preview-input input:file').val("");
                $(".image-preview-input-title").text("Browse"); 
            }); 
            // Create the preview image
            $(".image-preview-input input:file").change(function (){     
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });      
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".image-preview-input-title").text("Change");
                    $(".image-preview-clear").show();
                    $(".image-preview-filename").val(file.name);            
                    img.attr('src', e.target.result);
                    $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                }        
                reader.readAsDataURL(file);
            });  
        });

        $(function() {
            // Create the close button
            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview-cover_image',
                style: 'font-size: initial;',
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.cover_image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.cover_image-preview-clear').click(function(){
                $('.cover_image-preview').attr("data-content","").popover('hide');
                $('.cover_image-preview-filename').val("");
                $('.cover_image-preview-clear').hide();
                $('.cover_image-preview-input input:file').val("");
                $(".cover_image-preview-input-title").text("Browse"); 
            }); 
            // Create the preview image
            $(".cover_image-preview-input input:file").change(function (){     
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });      
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".cover_image-preview-input-title").text("Change");
                    $(".cover_image-preview-clear").show();
                    $(".cover_image-preview-filename").val(file.name);            
                    img.attr('src', e.target.result);
                    $(".cover_image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                }        
                reader.readAsDataURL(file);
            });  
        });
    },
    edit: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        $(document).on('click', '#close-preview', function(){ 
            $('.image-preview').popover('hide');
            // Hover befor close the preview
            $('.image-preview').hover(
                function () {
                   $('.image-preview').popover('show');
                }, 
                 function () {
                   $('.image-preview').popover('hide');
                }
            );    
        });

        $(document).on('click', '#close-preview-cover_image', function(){ 
            $('.cover_image-preview').popover('hide');
            // Hover befor close the preview
            $('.cover_image-preview').hover(
                function () {
                   $('.cover_image-preview').popover('show');
                }, 
                 function () {
                   $('.cover_image-preview').popover('hide');
                }
            );    
        });

        $(function() {
            // Create the close button
            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview',
                style: 'font-size: initial;',
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.image-preview-clear').click(function(){
                $('.image-preview').attr("data-content","").popover('hide');
                $('.image-preview-filename').val("");
                $('.image-preview-clear').hide();
                $('.image-preview-input input:file').val("");
                $(".image-preview-input-title").text("Browse"); 
            }); 
            // Create the preview image
            var img = $('<img/>', {
                id: 'dynamic',
                width:250,
                height:200
            });     

            if (window.thumbnail != '') {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(window.thumbnail); 
                img.attr('src', window.thumbnail);
                $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            }
            
            // if image has been changed
            $(".image-preview-input input:file").change(function (){     
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });      
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".image-preview-input-title").text("Change");
                    $(".image-preview-clear").show();
                    $(".image-preview-filename").val(file.name);            
                    img.attr('src', e.target.result);
                    $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                }        
                reader.readAsDataURL(file);
            });  
        });

        $(function() {
            // Create the close button
            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview-cover_image',
                style: 'font-size: initial;',
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.cover_image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.cover_image-preview-clear').click(function(){
                $('.cover_image-preview').attr("data-content","").popover('hide');
                $('.cover_image-preview-filename').val("");
                $('.cover_image-preview-clear').hide();
                $('.cover_image-preview-input input:file').val("");
                $(".cover_image-preview-input-title").text("Browse"); 
            }); 
            // Create the preview image
            var img = $('<img/>', {
                id: 'dynamic',
                width:250,
                height:200
            });     

            if (window.cover_image != '') {
                $(".cover_image-preview-input-title").text("Change");
                $(".cover_image-preview-clear").show();
                $(".cover_image-preview-filename").val(window.cover_image); 
                img.attr('src', window.cover_image);
                $(".cover_image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            }
            
            // if image has been changed
            $(".cover_image-preview-input input:file").change(function (){     
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });      
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".cover_image-preview-input-title").text("Change");
                    $(".cover_image-preview-clear").show();
                    $(".cover_image-preview-filename").val(file.name);            
                    img.attr('src', e.target.result);
                    $(".cover_image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                }        
                reader.readAsDataURL(file);
            });  
        });
    }
}

$(function () {
    const url = $(location).attr('pathname');
    const path = url.split('/');
    const page = path[path.length - 1];
    if (page == 'blogs') {
        $.blogs.init.activate();
    } else if (page == 'create') {
        $.blogs.init.create();
    } else if (page == 'edit') {
        $.blogs.init.edit();
    }
});