<div class='btn-group btn-group-sm'>
  @can('clothesCategories.show')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('clothesCategories.show', $id) }}" class='btn btn-link'>
    <i class="fa fa-eye"></i>
  </a>
  @endcan

  @can('clothesCategories.edit')
  <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.clothes_category_edit')}}" href="{{ route('clothesCategories.edit', $id) }}" class='btn btn-link'>
    <i class="fa fa-edit"></i>
  </a>
  @endcan

  @can('clothesCategories.destroy')
{!! Form::open(['route' => ['clothesCategories.destroy', $id], 'method' => 'delete']) !!}
  {!! Form::button('<i class="fa fa-trash"></i>', [
  'type' => 'submit',
  'class' => 'btn btn-link text-danger',
  'onclick' => "return confirm('Are you sure?')"
  ]) !!}
{!! Form::close() !!}
  @endcan
</div>
