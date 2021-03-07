<div class='btn-group btn-group-sm'>
    @if(in_array($id,$myReviews))
        @can('shopReviews.show')
            <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.view_details')}}" href="{{ route('shopReviews.show', $id) }}" class='btn btn-link'>
                <i class="fa fa-eye"></i> </a>
        @endcan

        @can('shopReviews.edit')
            <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.shop_review_edit')}}" href="{{ route('shopReviews.edit', $id) }}" class='btn btn-link'>
                <i class="fa fa-edit"></i> </a>
        @endcan

        @can('shopReviews.destroy')
            {!! Form::open(['route' => ['shopReviews.destroy', $id], 'method' => 'delete']) !!}
            {!! Form::button('<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-link text-danger',
            'onclick' => "return confirm('Are you sure?')"
            ]) !!}
            {!! Form::close() !!}
        @endcan
    @endif
</div>
