@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        {{-- <h1 class="m-0 text-dark">Beshoy <small class="ml-3 mr-3">|</small><small>{{trans('lang.clothes_category_desc')}}</small></h1> --}}
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{!! route('subcategory.index') !!}">{{trans('lang.clothes_category_plural')}}</a>
          </li>
          <li class="breadcrumb-item active">SubCategories</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="clearfix"></div>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.clothes_category_table')}}</a>
        </li>
        @can('clothesCategories.create')
        <li class="nav-item">
          <a class="nav-link" href="{!! route('subsize.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.clothes_category_create')}}</a>
        </li>
        @endcan
        {{-- @include('layouts.right_toolbar', compact('dataTable')) --}}
       </ul>
       </div>
       <div class="card-body">
        <table class="table table-striped" >
          <thead>
              <tr>
                 
                  <th>SubCategory Name </th>
                  <th>Related To</th>
                  <th>created at</th>
                  {{-- <th>edit</th> --}}
                  <th>delete</th>
                  
              </tr>
          </thead>
          <tbody>
              @foreach ($subcategories as $subcategory)
                  <tr class="odd gradeX">
                    {{-- {{dd($subcategory)}} --}}
                  <td>{{$subcategory->name}}</td>
                  <td>{{$subcategory->size? $subcategory->size->name : ''}}</td>
                  <td>{{$subcategory->created_at}}</td>
              {{-- <td><a class="btn btn-primary" href="#">edit</a></td> --}}
              <form action="{{route('subcategory.destroy',$subcategory->id)}}" method="POST">
              @csrf
              @method('Delete')
              <td class="center"><button type="submit" class="btn btn-danger remove"> delete</button></td>
            </form>
                 </tr>
              @endforeach
            
          </tbody>
      </table>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection


