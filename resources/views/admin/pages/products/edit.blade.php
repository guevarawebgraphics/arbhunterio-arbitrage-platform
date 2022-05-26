@extends('index')

@section('title')

@endsection

@section('extra-css')
<style>
    .image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .image-preview-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .image-preview-input-title {
        margin-left:2px;
    }	
    .metas .meta.first .btn-del {
        display: none;
    }
    .meta {
        margin-bottom: 1em;
    }

    #project-gallery-upload {
        display: flex;
        align-items: flex-end;
    }
    .gallery {
        display: flex;
        flex-wrap: wrap;
        flex-grow: 1;
    }

    .gallery-item {
        width: 24%;
        margin-bottom: 1%;
        position: relative;
        height: 160px;
        margin-left: 1%;
    }

    .gallery-item .btn {
        position: absolute;
        top: 0;
        right: 0;
    }
    .gallery-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    .gallery-item .btn-danger {
        background-color: #d9534f !important;
        border-color: #d43f3a !important;
        border-radius: 0 !important;
    }
    .no-gallery {
        width: 100%;
        margin: 2.5em 0;
        text-align: center;
    }
</style>
@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Edit Product Category: {{ $product->title }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
                </div>
                <div class="clearfix"></div>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CREATE PRODUCT FORM
                            </h2>
                        </div>
                        <div class="body">
                            {!! Form::model($product, ['method' => 'PATCH','route' => ['admin.products.update', $product->id], 'files' => true]) !!}
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('title', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">SKU</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('sku', null, array('placeholder' => 'SKU','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Description</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::textarea('content', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="group">Assign Product Category</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::select('id', $categories, $category, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Product Image</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="input-group image-preview">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                                    </button>
                                                    <div class="btn btn-default image-preview-input">
                                                        <span class="glyphicon glyphicon-folder-open"></span>
                                                        <span class="image-preview-input-title">Browse</span>
                                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="image"/>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Upload Product Gallery</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" id="images" name="images[]" accept=".jpg,.jpeg,.png" class="img_bg" multiple >
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Is active?</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_active" {{ Request::old('is_active') ? : ($product->is_active ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.pages.products.seo_metas', ['seo_meta_fields' => $product->seoMeta])
            {!! Form::close() !!}
            @include('admin.pages.products.gallery', ['product' => $product])
            <!-- #END# Body Copy -->
        </div>
@endsection

@section('extra-script')
{{Html::script('public/js/swal.js')}}
<script> 
    window.permissions = '<?php echo $permissions; ?>';
    window.image = '<?php echo url('/') . '/' . $product->image; ?>';
    $(function() {
        var container = $('.metas');
        $(document).on('click', '.btn-add', function() {

            let template = $('.metas .meta:first-child');

            let index = $('.metas .meta').length;

            let cloned = template.clone().removeClass('first');

            cloned.find('input').each(function(i, v) {

                // Replace index
                this.name = this.name.replace('[0]', '['+ index +']');
                
                // Set value to empty
                $(this).val('');

            })

            cloned.appendTo(container);
            return false;

        });

        $(document).on('click', '.btn-del', function(e) {
            if ($('.btn-del').size() > 2) {
                $(this).closest('.meta').remove();
                return false;
            } else {
                return false;
            }
        });

        $('.btn-delete').click(function() {
            const id = $(this).data('attachable-id');
            const deleteUrl = "{{ route('admin.products.gallery.delete', $product->id) }}";

            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : 'POST',
                        url  : deleteUrl,
                        data : {
                            _method: 'delete',
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function () {
                            Swal.fire("Deleted!", "Attachment has been deleted!", "success");
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    });
                    
                } else {
                    Swal.fire("Cancelled!", "Delete cancelled!", "error");
                }
            });
        });
    })
</script>
{{Html::script('public/js/bjcdl/libraries/products.js')}}
@endsection