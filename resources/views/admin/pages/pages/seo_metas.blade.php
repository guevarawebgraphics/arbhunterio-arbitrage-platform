<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    SEO METAS
                </h2>
            </div>
            <div class="body">
                <input type="hidden" name="seo_meta_id" value="{{ (!empty($page) ? $page->seo_meta_id : 0) }}">
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="name">Meta Title</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {!! Form::text('meta_title', Request::old('meta_title') ? old('meta_title') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_title : ''), array('placeholder' => 'Title','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="name">Meta Keywords</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {!! Form::text('meta_keywords', Request::old('meta_title') ? old('meta_title') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_title : ''), array('placeholder' => 'Keywords','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                        <label for="name">Meta Description</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {!! Form::textarea('meta_description', Request::old('meta_title') ? old('meta_title') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_description : ''), array('placeholder' => 'Description','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>