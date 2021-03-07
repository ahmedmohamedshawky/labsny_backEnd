<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name Field -->
<div class="form-group row ">
  {!! Form::label('name', trans("lang.colour_category_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.colour_category_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.colour_category_name_help") }}
    </div>
  </div>
</div>

<!-- Description Field -->
<div class="form-group row ">
  {!! Form::label('description', trans("lang.colour_category_desc"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
     trans("lang.colour_category_description_placeholder")  ]) !!}
    <div class="form-text text-muted">{{ trans("lang.colour_category_description_help") }}</div>
  </div>
</div>

<div class="form-group row">
  {!! Form::label('image', trans("lang.clothes_image"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
      <div style="width: 100%" class="dropzone image" id="image" data-field="image">
          <input type="hidden" name="image">
      </div>
      <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
      <div class="form-text text-muted w-50">
          {{ trans("lang.clothes_image_help") }}
      </div>
  </div>
</div>
@prepend('scripts')
        <script type="text/javascript">
            var var15671147171873255749ble = '';
            @if(isset($clothes) && $clothes->hasMedia('image'))
                var15671147171873255749ble = {
                name: "{!! $clothes->getFirstMedia('image')->name !!}",
                size: "{!! $clothes->getFirstMedia('image')->size !!}",
                type: "{!! $clothes->getFirstMedia('image')->mime_type !!}",
                collection_name: "{!! $clothes->getFirstMedia('image')->collection_name !!}"
            };
                    @endif
            var dz_var15671147171873255749ble = $(".dropzone.image").dropzone({
                    url: "{!!url('uploads/store')!!}",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    init: function () {
                        @if(isset($clothes) && $clothes->hasMedia('image'))
                        dzInit(this, var15671147171873255749ble, '{!! url($clothes->getFirstMediaUrl('image','thumb')) !!}')
                        @endif
                    },
                    accept: function (file, done) {
                        dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
                    },
                    sending: function (file, xhr, formData) {
                        dzSending(this, file, formData, '{!! csrf_token() !!}');
                    },
                    maxfilesexceeded: function (file) {
                        dz_var15671147171873255749ble[0].mockFile = '';
                        dzMaxfile(this, file);
                    },
                    complete: function (file) {
                        dzComplete(this, file, var15671147171873255749ble, dz_var15671147171873255749ble[0].mockFile);
                        dz_var15671147171873255749ble[0].mockFile = file;
                    },
                    removedfile: function (file) {
                        dzRemoveFile(
                            file, var15671147171873255749ble, '{!! url("clothes/remove-media") !!}',
                            'image', '{!! isset($clothes) ? $clothes->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                        );
                    }
                });
            dz_var15671147171873255749ble[0].mockFile = var15671147171873255749ble;
            dropzoneFields['image'] = dz_var15671147171873255749ble;
        </script>
@endprepend
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
</div>


<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.colour_category')}}</button>
  <a href="{!! route('colourCategories.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
