@if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        {!! Form::label('name', trans("lang.clothes_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_name_help") }}
            </div>
        </div>
    </div>

    <!-- Image Field -->
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

<!-- Price Field -->
    <div class="form-group row ">
        {!! Form::label('price', trans("lang.clothes_price"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('price', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_price_placeholder"),'step'=>"any", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_price_help") }}
            </div>
        </div>
    </div>

    <!-- Discount Price Field -->
    <div class="form-group row ">
        {!! Form::label('discount_price', trans("lang.clothes_discount_price"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('discount_price', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_discount_price_placeholder"),'step'=>"any", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_discount_price_help") }}
            </div>
        </div>
    </div>

    <!-- Description Field -->
    <div class="form-group row ">
        {!! Form::label('description', trans("lang.clothes_description"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
             trans("lang.clothes_description_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_description_help") }}</div>
        </div>
    </div>

    <!-- Amount Field -->
    <div class="form-group row ">
        {!! Form::label('amount', trans("lang.clothes_amount"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('amount', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_amount"),'step'=>"any", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_amount") }}
            </div>
        </div>
    </div>

</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

    <!-- Ingredients Field -->
    <div class="form-group row ">
        {!! Form::label('ingredients', trans("lang.clothes_ingredients"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('ingredients', null, ['class' => 'form-control','placeholder'=>
             trans("lang.clothes_ingredients_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_ingredients_help") }}</div>
        </div>
    </div>

    <!-- unit Field -->
    <div class="form-group row ">
        {!! Form::label('unit', trans("lang.clothes_unit"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('unit', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_unit_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_unit_help") }}
            </div>
        </div>
    </div>

    <!-- package_items_count Field -->
    <div class="form-group row ">
        {!! Form::label('package_items_count', trans("lang.clothes_package_items_count"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('package_items_count', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_package_items_count_placeholder"),'step'=>"any", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_package_items_count_help") }}
            </div>
        </div>
    </div>

    <!-- Weight Field -->
    <div class="form-group row ">
        {!! Form::label('weight', trans("lang.clothes_weight"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('weight', null,  ['class' => 'form-control','placeholder'=>  trans("lang.clothes_weight_placeholder"),'step'=>"0.01", 'min'=>"0"]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.clothes_weight_help") }}
            </div>
        </div>
    </div>

    <!-- 'Boolean Featured Field' -->
    <div class="form-group row ">
        {!! Form::label('featured', trans("lang.clothes_featured"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('featured', 0) !!}
                {!! Form::checkbox('featured', 1, null) !!}
            </label>
        </div>
    </div>

    <!-- 'Boolean deliverable Field' -->
    <div class="form-group row ">
        {!! Form::label('deliverable', trans("lang.clothes_deliverable"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('deliverable', 0) !!}
                {!! Form::checkbox('deliverable', 1, null) !!}
            </label>
        </div>
    </div>

    <!-- Shop Id Field -->
    <div class="form-group row ">
        {!! Form::label('shop_id', trans("lang.clothes_shop_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('shop_id', $shop, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_shop_id_help") }}</div>
        </div>
    </div>

    <!-- Sizes Field -->
    <div class="form-group row ">
        {!! Form::label('size[]', trans("lang.clothes_size_category"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('sizes[]', $size, $sizesSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple', 'required']) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_size_category") }}</div>
        </div>
    </div>

    <!-- Colours Field -->
    <div class="form-group row ">
        {!! Form::label('colour[]', trans("lang.clothes_colour_category"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('colours[]', $colour, $coloursSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple', 'required']) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_colour_category") }}</div>
        </div>
    </div>

    <!-- clothes Category Field -->
    <div class="form-group row ">
        {!! Form::label('clothesCategory[]', trans("lang.clothes_category"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('clothesCategory[]', $clothesCategory, $clothesCategorySelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple', 'required']) !!}
            <div class="form-text text-muted">{{ trans("lang.clothes_category") }}</div>
        </div>
    </div>
    
    @if(isset($type))
        <!-- clothes Category Field -->
        <div class="form-group row ">
            {!! Form::label('clothesType', trans("lang.clothes_type"),['class' => 'col-3 control-label text-right']) !!}
            <div class="col-9">
                {!! Form::label('clothesType', trans("lang.clothes_type_coins"),['class' => 'col-3 control-label text-right']) !!}
                    {!! Form::radio('type', 'coins', true) !!}

                {!! Form::label('clothesType', trans("lang.clothes_type_commission"),['class' => 'col-3 control-label text-right']) !!}
                {!! Form::radio('type', 'commission', false) !!}
            </div>
        </div>
    @endif

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
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.clothes')}}</button>
    <a href="{!! route('clothes.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
