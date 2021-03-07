<!-- Id offer -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->id !!}</p>
  </div>
</div>

<!-- Name offer -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->name !!}</p>
  </div>
</div>

<!-- Description offer -->
<div class="form-group row col-6">
  {!! Form::label('description', 'Description:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->description !!}</p>
  </div>
</div>

<!-- Image offer -->
<div class="form-group row col-6">
  {!! Form::label('image', 'Image:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->image !!}</p>
  </div>
</div>

<!-- Shop Id Field -->
<div class="form-group row col-6">
  {!! Form::label('shop_id', 'Shop Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->shop_id !!}</p>
  </div>
</div>

<!-- Created At offer -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->created_at !!}</p>
  </div>
</div>

<!-- Updated At offer -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $offer->updated_at !!}</p>
  </div>
</div>

