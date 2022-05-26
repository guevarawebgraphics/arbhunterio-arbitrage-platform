@if ($system_setting->type == 'textarea')
    <div class="row clearfix">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
            <label for="name">Value</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
            <div class="form-group">
                <div class="form-line">
                    {!! Form::textarea('value', Request::old('value') ? : $system_setting->value, array('placeholder' => 'Value','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
@elseif ($system_setting->type == 'ckeditor')
    <div class="row clearfix">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
            <label for="name">Value</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
            <div class="form-group">
                <div class="form-line">
                    {!! Form::textarea('value', Request::old('value') ? : $system_setting->value, array('placeholder' => 'Value', 'class' => 'form-control ckeditor', 'id' => 'value')) !!}
                </div>
            </div>
        </div>
    </div>
@elseif ($system_setting->type == 'file')
    <div class="row clearfix">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
            <label for="name">Value</label>
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
                                <input type="file" accept="image/png, image/jpeg, image/gif" name="value"/>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($system_setting->type == 'toggle')
    <div class="row clearfix">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
            <label for="name">Value</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
            <div class="form-group">
                <div class="form-line">
                    <div class="switch">
                        <label>
                            <input type="checkbox" value="1" name="value" {{ Request::old('is_active') ? : ($system_setting->value ? 'checked' : '') }}><span class="lever switch-col-blue"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else 
    <div class="row clearfix">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
            <label for="name">Value</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
            <div class="form-group">
                <div class="form-line">
                    {!! Form::text('value', Request::old('value') ? : $system_setting->value, array('placeholder' => 'Value','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
@endif