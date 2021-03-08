@extends('layouts.app')
@push('css_lib')
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
<!-- select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
{{--dropzone--}}
<link rel="stylesheet" href="{{asset('plugins/dropzone/bootstrap.min.css')}}">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{trans('lang.clothes_category_plural')}}<small class="ml-3 mr-3">|</small><small>SubCategories</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{!! route('clothesCategories.index') !!}">SubCategories</a>
          </li>
          <li class="breadcrumb-item active">Create subcategory</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="clearfix"></div>
  @include('flash::message')
  @include('adminlte-templates::common.errors')
  <div class="clearfix"></div>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        @can('clothesCategories.index')
        <li class="nav-item">
          <a class="nav-link" href="{!! route('clothesCategories.index') !!}"><i class="fa fa-list mr-2"></i>subcategories Table</a>
        </li>
        @endcan
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>Create SubCategory</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      {{-- {!! Form::open(['route' => 'clothesCategories.store']) !!} --}}
      <form action="{{route("subcategory.store")}}" method="POST">
      @csrf
      <input type="text" value="category_id" name="subfor" hidden>
        <div class="row">
          <div class="col-sm-6 col-12">
          <div class="form-group"> 
            <label>Category &nbsp; </label>
            {{-- <input type="text" class="form-control" name="categories" data-role="tagsinput"  value= @foreach ($project->Categories as $category){{ $category->name .' '}} @endforeach   > --}}
            <select name="category" class="js-example-basic-multiple" style="width: 100%" required>
              @foreach ($categories as $Category)
                  <option
                  {{-- @if (in_array($Category->id, $project->Categories()->pluck('Category_id')->toArray() )) --}}
                  {{-- selected --}}
                  {{-- @endif --}}
                  value="{{$Category->id}}">{{$Category->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <label>SubCategory &nbsp; </label>
                <input type="text" class="form-control" name="name" required >
          </div>
        </div>
      </div>
      <button class="btn btn-primary btn-cons"  style=" float:right;" >  Add SubCategory</button>
    </form>
      {{-- {!! Form::close() !!} --}}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@include('layouts.media_modal')
@endsection
@push('scripts_lib')
<!-- iCheck -->
{{-- <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script> --}}
<!-- select2 -->
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script> --}}
{{--dropzone--}}
{{-- <script src="{{asset('plugins/dropzone/dropzone.js')}}"></script> --}}
@endpush