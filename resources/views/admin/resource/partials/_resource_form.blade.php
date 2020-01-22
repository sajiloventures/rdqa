<div class="smart-form">
    <fieldset>
        <section>
            <label class="label">{{ trans($trans_path.'general.columns.name') }}</label>
            <label class="input">
                <i class="icon-prepend fa fa-arrow-right">
                </i>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.name'), 'required']) !!}
            </label>
        </section>

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.description') }}</label>
            <label class="textarea">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder'=>trans($admin_trans_path.'general.columns.description')]) !!}
            </label>
        </section>

        <section>
            <label class="label">{{ trans($admin_trans_path.'general.columns.status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="status" type="checkbox" class="checkbox" value="1" {{ isset($resource) && $resource->status == 1 ? 'checked' : null }} />
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
        <section>
            <div class="dropzone" id="fileUpload">
                <input type="file"  style="display: none;">
            </div>
        </section>
        <section>
            <h3>Uploaded files</h3>
            <p class="alert alert-danger showFileError" style="display: none;">At least one file is required.</p>
            <ul id="file-upload-list" class="list-unstyled margin-top-10">
                @php
                    $countFile = 0;
                    $files = [];
                    if (isset($resource) && $resource->files)
                        $files = explode('~,', $resource->files);
                    if (old('fileName'))
                        $files = old('fileName');
                @endphp
                @if(count($files) > 0)
                    @foreach($files as $file)
                        @if(File::exists(public_path(config('rdqa.asset_path.resource_file') . '/'. $file)))
                            <li data-index="{{ ++$countFile }}">
                                <span class="counterFile">{{ $countFile }}</span>. {{ $file }} <span class="pull-right"><a href="javascript:void(0)" class="text-danger removeFile"><i class="fa fa-remove"></i></a> </span>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-color-blue" role="progressbar" style="width: 100%;"></div>
                                </div>
                                <input type="hidden" name="fileName[]" value="{{ $file }}" />
                            </li>
                        @endif
                    @endforeach
                @endif

            </ul>
        </section>
    </fieldset>
</div>