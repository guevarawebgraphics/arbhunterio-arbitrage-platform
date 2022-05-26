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

    .cover_image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;    
        color: #333;
        background-color: #fff;
        border-color: #ccc;    
    }
    .cover_image-preview-input input[type=file] {
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
    .cover_image-preview-input-title {
        margin-left:2px;
    }	
</style>
@endsection

@section('content')
	<div class="container-fluid">
            <div class="block-header ">
                <div class="pull-left">
                    <h2>Edit Blog: "{{ $blog->title }}"</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.blogs.index') }}"> Back</a>
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
                                EDIT BLOG FORM
                            </h2>
                        </div>
                        <div class="body">
                            {!! Form::model($blog, ['method' => 'PATCH','route' => ['admin.blogs.update', $blog->id], 'files' => true]) !!}
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="group">Category</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::select('blog_category_id', $blog_categories, $blog->blog_category_id, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Title</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Author</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::text('author', null, array('placeholder' => 'Author','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Content</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control ckeditor')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Thumbnail</label>
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
                                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="thumbnail"/>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Cover Image</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="input-group cover_image-preview">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default cover_image-preview-clear" style="display:none;">
                                                        <span class="glyphicon glyphicon-remove"></span> Clear
                                                    </button>
                                                    <div class="btn btn-default cover_image-preview-input">
                                                        <span class="glyphicon glyphicon-folder-open"></span>
                                                        <span class="cover_image-preview-input-title">Browse</span>
                                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="cover_image"/>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Is active?</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_active" {{ Request::old('is_active') ? : ($blog->is_active ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                    <label for="name">Is Featured?</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" value="1" name="is_featured" {{ Request::old('is_featured') ? : ($blog->is_featured ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
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
            @include('admin.pages.pages.seo_metas', ['seo_meta_fields' => $blog->seoMeta])
            {!! Form::close() !!}
            <!-- #END# Body Copy -->
        </div>
@endsection

@section('extra-script')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
{{Html::script('public/js/swal.js')}}
<script>
    window.permissions = '<?php echo $permissions; ?>';
    window.thumbnail = '<?php echo url('/') . '/' . $blog->thumbnail; ?>';
    window.cover_image = '<?php echo url('/') . '/' . $blog->cover_image; ?>';
</script>
{{Html::script('public/js/bjcdl/libraries/blogs.js')}}
@endsection