<div class='btn-group btn-group-sm'>
  @can('shopsPayouts.show')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('shopsPayouts.show', $id) }}" class='btn btn-link'>
    <i class="fa fa-eye"></i>
  </a>
  @endcan

  @can('shopsPayouts.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.shops_payout_edit')}}" href="{{ route('shopsPayouts.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('shopsPayouts.destroy')
{!! Form::open(['route' => ['shopsPayouts.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
