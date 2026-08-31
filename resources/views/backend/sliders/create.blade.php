@extends('layouts.backend')
@section('title', 'Create Slider')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/select2/css/select2.min.css')}}">
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

    .up3 {
        position: relative;
        top: -3px;
    }

    .el_field {
        width: 100%;
        height: 80px;
        border-radius: 3px;
        background: #ffffff;
        padding: 10px;
        margin-top: 10px;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        box-shadow: 0px 0px 5px 1px #e7e7e7;
    }

    .el_field .field_nams b {
        display: block;
        line-height: 16px;
    }

    .el_field .field_nams span {
        font-size: 12px;
        display: inline-block;
        width: 150px;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }

    .el_field .col_field {
        width: 25%;
    }

    .el_field .field_nams {
        width: 50%;
    }

    .el_field .field_tools {
        width: 25%;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        flex-direction: row;
    }

    .el_field .fmove {
        width: 24px;
        text-align: center;
        background: #188ae2;
        border-radius: 4px;
    }

    .el_field .fmove a {
        color: white;
    }

    .el_field .ftrash a {
        color: white;
    }

    .el_field .ftrash {
        width: 24px;
        text-align: center;
        background: #a7331e;
        border-radius: 4px;
        margin-left: 3px;
    }
    .imagepreview img{
        padding: .25rem;
        background-color: var(--bs-body-bg);
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        max-width: 100%;
        max-height: 300px;
    }
</style>
@endsection
@section('content')
<form action="{{route('sliders.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Sliders
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('sliders.index')}}">Sliders</a>
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
            <div class="col-md-5">
                <input type="text" name="name" class="form-control light-fields" placeholder="Name" required>
                @csrf
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <small>Image height must be 550px</small>
                        </h3>
                        <a href="javascript:void(0)" id="addSlider" class="pull-right btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="row" id="sliders"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('customScripts')
<script src="{{asset('assets_backend/js/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $('.image-placeholder').filemanager('image');
    One.helpersOnLoad(['jq-select2']);

    jQuery(document).ready(function(){
        $("#sliders").sortable({
            handle: ".handle",
            axis: 'y'
        });
    });

    $("#addSlider").on('click',function(){
        var count = Math.floor((Math.random() * 999) + 1);
        var html = `
                    <div class="block block-rounded mt-1 pb-1 removeDiv">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Slider Image
                            </h3>
                            <a href="javascript:;" class="handle"><i class="fa fa-arrows"></i></a>
                            <span class="divider" style="margin: 0 5px;"></span>
                            <a data-id="edit_slider${count}" class="edit_slider"><i class="fa fa-minus"></i></a>
                            <span class="divider" style="margin: 0 5px;"></span>
                            <a href="#" class="remove_slider"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="block-content" id="edit_slider${count}">
                            <div class="row">
                                <div class="form-group text-center m-b-20">
                                    <div class="image-placeholder" id="wfm" data-input="hidden-`+count+`" data-preview="holder-`+count+`">
                                        <div class="imagepreview" id="holder-`+count+`">
                                            <img src="{{asset('placeholder.png')}}">
                                        </div>

                                    </div>
                                    <input type="hidden" name="slider[image][]" id="hidden-`+count+`">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        $("#sliders").append(html);
        $('.image-placeholder').filemanager('image');
    });

    $(document).on('click','.edit_slider',function(){
        var id = $(this).data('id');
        $('.image-placeholder').filemanager('image');
        var slider = $("#" + id);
        var icon = $(this).find('i');
        if (slider.is(':visible')) {
            slider.slideUp();
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            slider.slideDown();
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
        $("#edit_slider"+id).show();
    });

    $(document).on('click','.remove_slider',function(){
        $(this).parents('.removeDiv').remove();
    });
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
