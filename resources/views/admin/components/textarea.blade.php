<div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
        <label for="name">{{ ucwords($field) }}</label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
        <div class="form-group">
            <div class="form-line">
                {!! Form::textarea($field, Request::old($field) ?: $value, array('placeholder' => 'Enter ' . $label, 'class' => 'form-control')) !!}
            </div>
        </div>
    </div>
</div>