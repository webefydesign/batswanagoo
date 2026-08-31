@extends('layouts.backend')
@section('title', 'Create Plan Type')
@section('customStyles')
<link href="{{asset('assets_backend/css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css">
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
<form action="{{route('plan-types.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Plan Types
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('plan-types.index')}}">Plan Types</a>
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
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Title" required>
                @csrf
            </div>
            <div class="col-md-6">
                <div class="slug-field">
                    <input type="text" name="slug" class="form-control light-fields" id="page-slug" placeholder="Slug" required>
                    <a href="javscript:;" class="text-dark" id="generateSlug"><i class="fa fa-refresh"></i></a>
                </div>
            </div>                        
        </div>
        </div>
    </div>
    
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Details</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Image</label>
                            <div class="input-group pull-left">
                                <span class="input-group-btn">
                                    <a data-input="image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                </span>
                                <input id="image" class="form-control input-sm" type="text" name="image">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Color</label>
                            <input type="color" class="form-control" name="color">
                        </div>
                    </div>
                </div>
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Points</h3>
                        <a href="javascript:;" class="btn btn-sm btn-info" id="addPoint"><i class="fa fa-plus"></i> Add</a>
                    </div>
                    <div class="block-content">
                        <div class="row" id="allPoints">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">                
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Categories</h3>
                      </div>
                    <div class="block-content">
                        <select multiple="multiple" id="cat-select" name="categories[]">
                            @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
</form>
@endsection
@section('customScripts')
<script src="{{asset('assets_backend/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $(document).on('click','#generateSlug',function(){
        $("#page-slug").val(convertToSlug($('#page-title').val()));
    });
    function convertToSlug(Text) {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }
    $('#cat-select').multiSelect()
    $('.image-placeholder').filemanager('image');

    $(document).on('click', '#addPoint', function() {
        $('#allPoints').append(`<div class="col-sm-12">
                <div class="row mt-3">
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="points[]" placeholder="Point">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-danger removePoint btn-sm"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`);
    });
    $(document).on('click', '.removePoint', function() {
        $(this).parent().parent().remove();
    });
</script>
@endsection