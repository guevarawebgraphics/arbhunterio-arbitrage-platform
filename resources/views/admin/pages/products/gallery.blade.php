<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    PRODUCT GALLERY
                </h2>
            </div>
            <div class="body">
                
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label well">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 text-center">
                                {!! Form::open([
                                    'id'    => 'project-gallery-upload',
                                    'url'   => route('admin.products.gallery.upload', $product->id),
                                    'files' => TRUE
                                ]) !!}
                                    <input type="file" id="images" name="images[]" accept=".jpg,.jpeg,.png" class="img_bg" multiple>
                                    <br>
                                    <button type="submit" class="btn btn-sm btn-primary"> Upload</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 text-center">
                                <div class="gallery">
                                    @forelse ($product->gallery as $image)
                                    <div class="gallery-item gallery-item-{{ $image->id }}">
                                        <img src="{{ $image->url }}" alt="{{ $product->slug }}-gallery-img-{{ $image->id }}">
                                        <button class="btn btn-sm btn-danger btn-delete" data-attachable-id="{{ $image->id }}">
                                            X
                                        </button>
                                    </div>
                                    @empty
                                        <p class="no-gallery"><em>No gallery image found.</em></p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>