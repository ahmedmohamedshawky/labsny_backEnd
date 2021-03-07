<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->id !!}</p>
  </div>
</div>

<!-- Price Field -->
<div class="form-group row col-6">
  {!! Form::label('price', 'Price:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->price !!}</p>
  </div>
</div>

<!-- Quantity Field -->
<div class="form-group row col-6">
  {!! Form::label('quantity', 'Quantity:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->quantity !!}</p>
  </div>
</div>

<!-- Clothes Id Field -->
<div class="form-group row col-6">
  {!! Form::label('clothes_id', 'Clothes Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->clothes_id !!}</p>
  </div>
</div>

<!-- Extras Field -->
<div class="form-group row col-6">
  {!! Form::label('extras', 'Extras:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->extras !!}</p>
  </div>
</div>

<!-- Order Id Field -->
<div class="form-group row col-6">
  {!! Form::label('order_id', 'Order Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->order_id !!}</p>
  </div>
</div>

<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesOrder->updated_at !!}</p>
  </div>
</div>

