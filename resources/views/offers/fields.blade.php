@if($customFields)
<h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name offer -->
<div class="form-group row ">
  {!! Form::label('name', trans("lang.offer_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.offer_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.offer_name_help") }}
    </div>
  </div>
</div>

<!-- Description offer -->
<div class="form-group row ">
  {!! Form::label('description', trans("lang.offer_description"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
     trans("lang.offer_description_placeholder")  ]) !!}
    <div class="form-text text-muted">{{ trans("lang.offer_description_help") }}</div>
  </div>
</div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

<!-- Image offer -->
<div class="form-group row">
  {!! Form::label('image', trans("lang.offer_image"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <div style="width: 100%" class="dropzone image" id="image" data-field="image">
      <input type="hidden" name="image">
    </div>
    <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
    <div class="form-text text-muted w-50">
      {{ trans("lang.offer_image_help") }}
    </div>
  </div>
</div>
@prepend('scripts')
<script type="text/javascript">
    var var15866134631720934041ble = '';
    @if(isset($offer) && $offer->hasMedia('image'))
    var15866134631720934041ble = {
        name: "{!! $offer->getFirstMedia('image')->name !!}",
        size: "{!! $offer->getFirstMedia('image')->size !!}",
        type: "{!! $offer->getFirstMedia('image')->mime_type !!}",
        collection_name: "{!! $offer->getFirstMedia('image')->collection_name !!}"};
    @endif
    var dz_var15866134631720934041ble = $(".dropzone.image").dropzone({
        url: "{!!url('uploads/store')!!}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
        @if(isset($offer) && $offer->hasMedia('image'))
            dzInit(this,var15866134631720934041ble,'{!! url($offer->getFirstMediaUrl('image','thumb')) !!}')
        @endif
        },
        accept: function(file, done) {
            dzAccept(file,done,this.element,"{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this,file,formData,'{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_var15866134631720934041ble[0].mockFile = '';
            dzMaxfile(this,file);
        },
        complete: function (file) {
            dzComplete(this, file, var15866134631720934041ble, dz_var15866134631720934041ble[0].mockFile);
            dz_var15866134631720934041ble[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, var15866134631720934041ble, '{!! url("offers/remove-media") !!}',
                'image', '{!! isset($offer) ? $offer->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
            );
        }
    });
    dz_var15866134631720934041ble[0].mockFile = var15866134631720934041ble;
    dropzoneoffers['image'] = dz_var15866134631720934041ble;
</script>
@endprepend

<!-- Shop Id Field -->
<div class="form-group row ">
  {!! Form::label('shop_id', trans("lang.clothes_shop_id"),['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
      {!! Form::select('shop_id', $shop, null, ['class' => 'select2 form-control']) !!}
      <div class="form-text text-muted">{{ trans("lang.clothes_shop_id_help") }}</div>
  </div>
</div>

@hasanyrole('admin')
<div class="form-group row ">
  {!! Form::label('active', trans("lang.offer_active"),['class' => 'col-3 control-label text-right']) !!}
  <div class="checkbox icheck">
      <label class="col-9 ml-2 form-check-inline">
          {!! Form::hidden('active', 0) !!}
          {!! Form::checkbox('active', 1, null) !!}
      </label>
  </div>
</div>
@endhasanyrole
</div>
@if($customFields)
<div class="clearfix"></div>
<div class="col-12 custom-field-container">
  <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
  {!! $customFields !!}
</div>
@endif
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.offer')}}</button>
  <a href="{!! route('offers.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
