if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': "<?php echo csrf_token() ?>"
    }
});

var fetchImg = '';

$.pages = {};

$.pages.init = {
    activate: function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var permissions = JSON.parse(window.permissions.split('\\'));

        var table = $('#pages-table').DataTable({
            ajax: '',
            serverSide: true,
            processing: true,
            aaSorting:[[0,"desc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'slug', name: 'slug'},
                {data: 'action', name: 'action'},
            ]
        });


        $(document).on('click','.btn-delete',function(){
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data record. Please keep in mind that the generated blade/view file will not be deleted.',
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
                        url: sAdminBaseURI + '/pages/' + rowid +'/delete',
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
                                                url: sAdminBaseURI + '/pages/' + rowid +'/restore',
                                                success: function (data) {
                                                    $('#pages-table').DataTable().ajax.reload();
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

            if (window.banner_image != '') {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(window.banner_image); 
                img.attr('src', window.banner_image);
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

        //sections
        window.sections.forEach((section) => {
            if (section.type == 3) {
                var form = section.value;
                
                form.data.forEach((data) => {
                    Object.values(form.data).forEach((key, value) => {
                        var field = form.fields.filter(function (fld) {
                            var alias = fld.alias ?? $.pages.init.slugify(fld.name);
                            return fld.alias === alias;
                        });
                        field.forEach((f) => {
                            if (f.type === "attachment") {
                                $(document).on('click', '#close-preview-' + data[f.alias], function(){ 
                                    $('#image-preview-section-' + f.alias).popover('hide');
                                    // Hover before close the preview
                                    $('#image-preview-section-' + f.alias).hover(
                                        function () {
                                           $('#image-preview-section-' + f.alias).popover('show');
                                        }, 
                                         function () {
                                           $('#image-preview-section-' + f.alias).popover('hide');
                                        }
                                    );    
                                });

                                $(function() {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {_method: 'GET', _token:token},
                                        method: "GET",
                                        url: sAdminBaseURI + '/pages/' + data[f.alias] +'/fetchAttachment',
                                        success: function (result) {
                                            fetchImg = result;
                                            // Create the close button
                                            var closebtn = $('<button/>', {
                                                type:"button",
                                                text: 'x',
                                                id: 'close-preview-' + data[f.alias],
                                                style: 'font-size: initial;',
                                            });
                                            closebtn.attr("class","close pull-right");
                                            // Set the popover default content
                                            $('#image-preview-section-' + f.alias).popover({
                                                trigger:'manual',
                                                html:true,
                                                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                                                content: "There's no image",
                                                placement:'bottom'
                                            });
                                            // Clear event
                                            $('#image-preview-clear-section-' + f.alias).click(function(){
                                                $('#image-preview-section-' + f.alias).attr("data-content","").popover('hide');
                                                $('#image-preview-filename-section-' + f.alias).val("");
                                                $('#image-preview-clear-section-' + f.alias).hide();
                                                $('#image-preview-input-section-' + f.alias + ' input:file').val("");
                                                $(".image-preview-input-title-section").text("Browse"); 
                                            }); 
                                            // Create the preview image
                                            var imgSection = $('<img/>', {
                                                id: 'dynamic',
                                                width:250,
                                                height:200
                                            });     
                                            
                                            if (fetchImg != '') {
                                                $(".image-preview-input-title-section").text("Change");
                                                $("#image-preview-clear-section-" + f.alias).show();
                                                $("#image-preview-filename-section-" + f.alias).val(fetchImg); 
                                                imgSection.attr('src', fetchImg);
                                                $("#image-preview-section-" + f.alias).attr("data-content",$(imgSection)[0].outerHTML).popover("show");
                                            }

                                            // if image has been changed
                                            $("#image-preview-input-section-" + f.alias + " input:file").change(function (){     
                                                var imgSection = $('<img/>', {
                                                    id: 'dynamic',
                                                    width:250,
                                                    height:200
                                                });      
                                                var file = this.files[0];
                                                var reader = new FileReader();
                                                // Set preview image into the popover data-content
                                                reader.onload = function (e) {
                                                    $(".image-preview-input-title-section").text("Change");
                                                    $("#image-preview-clear-section-" + f.alias).show();
                                                    $("#image-preview-filename-section-" + f.alias).val(file.name);            
                                                    imgSection.attr('src', e.target.result);
                                                    $("#image-preview-section-" + f.alias).attr("data-content",$(imgSection)[0].outerHTML).popover("show");
                                                }        
                                                reader.readAsDataURL(file);
                                            });  
                                        },
                                    });
                                    
                                });
                            }
                        });
                    });
                });
            }
        });
    }
}

$(function () {
    const url = $(location).attr('pathname');
    const path = url.split('/');
    const page = path[path.length - 1];
    if (page == 'pages') {
        $.pages.init.activate();
    } else if (page == 'create') {
        $.pages.init.create();
    } else if (page == 'edit') {
        $.pages.init.edit();
    }
});