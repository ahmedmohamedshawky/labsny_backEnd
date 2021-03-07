<div class='btn-group btn-group-sm'>
  @can('clothesOrders.show')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('clothesOrders.show', $id) }}" class='btn btn-link'>
    <i class="fa fa-eye"></i>
  </a>
  @endcan

  @can('clothesOrders.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.clothes_order_edit')}}" href="{{ route('clothesOrders.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

    @can('orders.edit')
      <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.order_edit')}}" href="{{ route('orders.edit', $order['id']) }}" class='btn btn-link'>
        <i class="fa fa-tasks"></i>
      </a>
    @endcan

  @can('clothesOrders.destroy')
{!! Form::open(['route' => ['clothesOrders.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
