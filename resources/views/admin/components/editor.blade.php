<div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
        <label for="name">{{ ucwords($field) }}</label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
        <div class="form-group">
            <div class="form-line">
                <textarea
                  @if(empty($async) || $async == false)
                  id="career_{{ $field }}"
                  name="{{ $field }}"
                  @else
                  id="{{ str_random(12) }}"
                  data-name="{{ $field }}"
                  @endif
                  rows="9"
                  class="form-control ckeditor fld"
                  placeholder="Enter {{ $field }}...">{{ old($field) ?: (empty($value) ? '' : $value) }}</textarea>
            </div>
        </div>
    </div>
</div>