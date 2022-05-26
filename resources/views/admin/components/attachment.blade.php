<div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
        <label for="name">{{ ucwords($label) }}</label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
        <div class="form-group">
            <div class="form-line">
                <div class="input-group image-preview-section" id="image-preview-section-{{ $field }}">
                    <span class="input-group-btn">
                        @php
                            $name = !empty($async) && $async ? '' : $field;
                        @endphp
                        <button type="button" class="btn btn-default image-preview-clear-section" id="image-preview-clear-section-{{ $field }}" style="display:none;">
                            <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>
                        <div class="btn btn-default image-preview-input-section" id="image-preview-input-section-{{ $field }}">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            <span class="image-preview-input-title-section">Browse</span>
                            {{-- <input type="file" class="fld" accept="image/png, image/jpeg, image/gif" name="{{ $name }}"/> --}}
                            <input type="file" class="{{ !empty($async) && $async ? 'async' : '' }}" accept="image/png, image/jpeg, image/gif" name="{{ $name }}">
                            <input type="hidden" class="fld" data-name="{{ $field }}" name="{{ $name }}" value="{{ isset($value) && !empty($value) ? $value->id : 0 }}">
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>