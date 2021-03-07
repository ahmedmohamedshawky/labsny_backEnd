<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->id !!}</p>
  </div>
</div>

<!-- Review Field -->
<div class="form-group row col-6">
  {!! Form::label('review', 'Review:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->review !!}</p>
  </div>
</div>

<!-- Rate Field -->
<div class="form-group row col-6">
  {!! Form::label('rate', 'Rate:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->rate !!}</p>
  </div>
</div>

<!-- User Id Field -->
<div class="form-group row col-6">
  {!! Form::label('user_id', 'User Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->user_id !!}</p>
  </div>
</div>

<!-- Clothes Id Field -->
<div class="form-group row col-6">
  {!! Form::label('clothes_id', 'Clothes Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->clothes_id !!}</p>
  </div>
</div>

<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->created_at !!}</p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $clothesReview->updated_at !!}</p>
  </div>
</div>

