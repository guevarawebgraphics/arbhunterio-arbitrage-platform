<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @foreach($page->sections as $section)
            @if($section->isEditor)
                @include('admin.components.editor', ['field' => $section->alias, 'label' => $section->name, 'value' => $section->value])

            @elseif($section->isAttachment)
                @include('admin.components.attachment', ['field' => $section->alias, 'label' => $section->name, 'value' => $section->attachment])

            @elseif($section->isForm)
                <input type="hidden" name="{{ $section->alias }}">
                @php
                    $form = json_decode($section->value);
                @endphp
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 style="border-left: 3px solid #61dbd5; padding-left: 8px; margin-bottom: 20px;"></h4>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            {{ ucwords($section->name) }}
                        </h2>
                    </div>
                    <div class="body">
                        <div id="section-{{ $section->id }}" style="margin-bottom: 50px;">
                            @foreach($form->data as $index => $data)
                                <div class="form-field">
                                    @foreach ($data as $key => $value)
                                        @php
                                            $field = collect($form->fields)->filter(function ($fld) use ($key) {
                                                $alias = $fld->alias ?? str_slug($fld->name);

                                                return $key === $alias;
                                            })->first();
                                            $alias = $field->alias ?? str_slug($field->name);
                                        @endphp
                                        @if ($field->type === 'text')
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">{{ ucwords($field->name) }}</label>
                                                </div>
                                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control fld" data-name="{{ $alias }}" value="{{ $value }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($field->type === 'numeric')
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">{{ ucwords($field->name) }}</label>
                                                </div>
                                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="number" class="form-control fld" data-name="{{ $alias }}" value="{{ $value }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($field->type === 'textarea')
                                            <div class="row clearfix">
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                    <label for="name">{{ ucwords($field->name) }}</label>
                                                </div>
                                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea class="fld form-control" data-name="{{ $alias }}" rows="4">{{ $value }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($field->type === 'attachment')
                                            @include('admin.components.attachment', ['field' => $alias, 'label' => $field->name, 'value' => \App\Services\Attachments\Attachment::find($value), 'async' => true])
                                        @elseif ($field->type === 'editor')
                                            @include('admin.components.editor', ['field' => $alias, 'label' => $field->name, 'value' => $value, 'async' => true])
                                        @endif
                                    @endforeach
                                </div>

                                @if(!$loop->last)
                                    <hr/>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>