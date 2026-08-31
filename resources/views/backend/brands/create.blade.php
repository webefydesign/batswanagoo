@extends('layouts.backend')
@section('title', 'Create Brand')
@section('customStyles')
<style>
    .light-fields {
        background: transparent;
        border: 2px solid #cecece;
        padding: 11px;
        border-radius: 12px;
    }
    .slug-field {
        position: relative;
    }
    .slug-field a {
        position: absolute;
        top: 11px;
        right: 17px;
    }   
</style>
@endsection
@section('content')
<form action="{{route('brands.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Brands
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('brands.index')}}">Brands</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  Create 
                </li>
              </ol>
            </div>
            <button type="submit" class="btn btn-outline-success me-1 mb-3">
                <i class="fa fa-fw fa-save me-1"></i> Save
            </button>        
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Brand Name" required>
                @csrf
            </div>            
            <div class="col-md-6">
                <select name="category_id" class="form-control light-fields select2">
                    <option value="">Select Category</option>
                    @foreach($categories as $p)
                    <option value="{{$p->id}}">{{$p->name}}</option>
                    @endforeach
                </select>
            </div>            
        </div>
        </div>
    </div>
    
    <div class="content">      
      <div class="block block-rounded mt-3">
          <div class="block-header block-header-default">
            <h3 class="block-title">Other Details</h3>
          </div>
          <div class="block-content">
            <div class="row pb-3">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Image</label>
                    <div class="input-group pull-left">
                        <span class="input-group-btn">
                            <a data-input="seriveImg" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                        <input id="seriveImg" class="form-control input-sm" type="text" name="image">
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" min="1" value="{{$sort_order}}" step="1">
                  </div>
              </div>
            </div>            
          </div>
      </div>
    </div>
</form>
@endsection
@section('customScripts')
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $('.image-placeholder').filemanager('image');    
</script>
@endsection