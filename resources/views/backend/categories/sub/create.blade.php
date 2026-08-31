@extends('layouts.backend')
@section('title', 'Create Category')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/js/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets_backend/css/bootstrap-tagsinput.css')}}" />
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
</style>
@endsection
@section('content')
<form action="{{route('sub-categories.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Sub Categories
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('categories.index')}}">Categories</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('sub-categories.index')}}">Sub Categories</a>
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
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Title" required>
                @csrf
            </div>
            <div class="col-md-4">
                <div class="slug-field">
                    <input type="text" name="slug" class="form-control light-fields" id="page-slug" placeholder="Slug" required>
                    <a href="javscript:;" class="text-dark" id="generateSlug"><i class="fa fa-refresh"></i></a>
                </div>
            </div>                        
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Parent</label>
                    <select name="parent_id" class="form-select light-fields js-select2">
                        <option value="">No Parent</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @include('backend.categories.options', [
                                'category' => $category,
                                'space' => '&nbsp;&nbsp;&nbsp;',
                            ])
                        @endforeach
                    </select>
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
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Icon</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="icon" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="icon" class="form-control input-sm" type="text" name="icon_image">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="image" class="form-control input-sm" type="text" name="image">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Sort Order</label>
                            <input type="text" class="form-control" name="sort_order" value="{{$sort_order}}">
                        </div>                        
                    </div>
                </div>                
            </div>
            <div class="col-md-6">                
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Category Feilds</h3>
                      </div>
                    <div class="block-content">
                        <label>
                            <input type="checkbox" name="parent_fields" value="1">
                            <span class="up3"> Pick parent fields </span>
                        </label>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Fields</label>
                                <div style="display: flex;">
                                    <select class="form-control field_select select2">
                                        <option value="">Select Any Field</option>
                                        <optgroup label="Fixed Fields">
                                            <option value="0" data-module="make" data-fieldValue="">Vehicles
                                                Make</option>
                                            <option value="0" data-module="model" data-fieldValue="">
                                                Vehicles Make Model</option>                                            
                                            <option value="0" data-module="body_type" data-fieldValue="">
                                                Vehicles Body Type</option>                                            
                                        </optgroup>
                                        <optgroup label="Dynamic Fields">
                                            @foreach ($fields as $field)
                                                <option value="{{ $field->id }}"
                                                    data-fieldValue="{{ json_encode($field->data) }}">
                                                    {{ $field->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-success addField"
                                        style="margin-left:10px;"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-sm-12 all_fields">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block block-rounded mt-3">
                    <div class="block-header block-header-default">
                      <h3 class="block-title">Seo Data</h3>
                    </div>
                    <div class="block-content">
                      <div class="row justify-content-center">
                        <div class="col-md-12">                          
                            <div class="mb-4">
                                <label class="form-label" for="meta_title">Title</label>
                                <input type="text" class="js-maxlength form-control" id="meta_title" name="meta_title" data-always-show="true" data-placement="top">
                                {{-- <div class="form-text">
                                  55 Character Max
                                </div> --}}
                              </div>                
                              <div class="mb-3">
                                <label class="form-label" for="meta_desc">Description</label>
                                <textarea class="js-maxlength form-control" id="meta_desc" name="meta_description" rows="4" data-always-show="true" data-placement="top"></textarea>
                                {{-- <div class="form-text">
                                  115 Character Max
                                </div> --}}
                              </div>                                            
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="og_tag" type="checkbox" id="og-tag" name="seo_meta[og_tag]" value="1">
                            <label class="form-check-label" for="og-tag">og: Open Graph</label>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="twitter_tag" type="checkbox" id="twitter-tag" name="seo_meta[twitter_tag]" value="1">
                            <label class="form-check-label" for="twitter-tag">Twitter Tags</label>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="schema" type="checkbox" id="schema-tag" name="seo_meta[is_schema]" value="1">
                            <label class="form-check-label" for="schema-tag">Schema Code</label>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="tags" type="checkbox" id="meta-tags" name="seo_meta[is_tags]" value="1">
                            <label class="form-check-label" for="meta-tags">Meta Keywords</label>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="scripts" type="checkbox" id="script_tags" name="seo_meta[script_tags]" value="1">
                            <label class="form-check-label" for="script_tags">Custom Scripts</label>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input seo-switch" data-type="canonicals" type="checkbox" id="is_canonicals" name="seo_meta[is_canonicals]" value="1">
                            <label class="form-check-label" for="is_canonicals">Link Canonicals</label>
                          </div>
                        </div>              
                      </div>
                      <hr>
                      <div class="row mb-4" id="og_tag_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">OG TAGS</h5>
                        <hr>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Title</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[og][title]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">URL</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[og][url]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Type</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[og][type]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">OG Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="og-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="og-image" class="form-control input-sm" type="text" name="seo_meta[og][image]">
                                </div>   
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="seo_meta[og][description]"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="row mb-4" id="twitter_tag_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">Twitter Tag</h5>
                        <hr>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Title</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[twitter][title]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">URL</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[twitter][url]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Card</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="seo_meta[twitter][card]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="twitter-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="twitter-image" class="form-control input-sm" type="text" name="seo_meta[twitter][image]">
                                </div>   
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="seo_meta[twitter][description]"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="row mb-4" id="schema_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">Schema Code</h5>
                        <hr>
                        <div class="col-md-12">
                            <textarea name="schema_code" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        </div>              
                      <div class="row mb-4" id="tags_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">Meta Keywords</h5>
                        <hr>
                        <div class="col-md-12">
                            <input type="text" class="form-control" data-role="tagsinput" name="seo_meta[meta_tags]">
                        </div>
                        </div>
                      <div class="row mb-4" id="scripts_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">Custom Scripts</h5>
                        <hr>
                        <div class="col-md-12">
                          <textarea name="scripts" class="form-control" cols="30" rows="6"></textarea>
                        </div>
                        </div>
                      <div class="row mb-4" id="canonicals_div" style="display: none;">
                        <hr>
                        <h5 style="padding-left: 20px;">Link Canonicals</h5>
                        <hr>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="col-xs-5 control-label">href</label>
                            <div class="col-xs-12 link-can">
                                <div style="position:relative;margin-top:5px;">
                                    <input type="text" class="form-control" name="seo_meta[canonical][]"
                                        value="">
                                    <button type="button" class="btn btn-sm btn-info add-canonical"
                                        style="position:absolute;top:0px;right:5px;">ADD</button>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
</form>
@endsection
@section('customScripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('assets_backend/js/plugins/select2/js/select2.full.min.js')}}"></script>
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
    $('.image-placeholder').filemanager('image');    
    One.helpersOnLoad(['jq-select2']);
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(".all_fields").sortable({
        handle: ".handle",
        axis: 'y'
    });

    $(document).on('click', '.addField', function() {
        var field = $('.field_select').val();
        if (field == null || field == '') {
            return false;
        }

        var text = $('.field_select').find('option:selected').text();
        var data = $('.field_select').find('option:selected').attr('data-fieldValue');
        var mod = $('.field_select').find('option:selected').attr('data-module');
        var post = $('.field_select').find('option:selected').attr('data-post');
        var i = Math.floor(Math.random() * 9000);
        var options = ``;

        post = (post != undefined) ? post : 0;

        mod = (mod == undefined) ? null : mod;
        data = (data != undefined && data != '' && data != null) ? JSON.parse(data) : '';
        if (data && data.options != undefined) {
            options = `<span>` + data.options.split(',').join(', ') + `</span>`;
        }

        var html = `
        <div class="el_field">
            <div class="field_nams">
                <input type="hidden" name="field[` + i + `][id]" value="` + field + `">
                <input type="hidden" name="field[` + i + `][module]" value="` + mod + `">
                <input type="hidden" name="field[` + i + `][post_id]" value="` + post + `">
                <div class="field_nam_flex">
                    <b>` + text + `</b>
                    <div>
                        <label>
                            <input type="checkbox" name="field[` + i + `][is_required]" value="1">
                            <span style="position:relative;top: 1px;"> Required </span>
                        </label>
                    </div>
                </div>
                <span class="op">` + options + `</span>
            </div>
            <div class="field_tools">
                <div class="fmove">
                    <a href="javascript:void" class="handle"> <i class="fa fa-arrows"></i> </a>
                </div>
                <div class="ftrash">
                    <a href="javascript:void" class="removeField"> <i class="fa fa-times"></i> </a>
                </div>
            </div>

            <div class="col_field" style="margin-right: 10px">
                <label>Title</label>
                <input name="field[` + i + `][title]" class="form-control input-sm" type="text">
            </div>
            <div class="col_field">
                <label>Width</label>
                <select name="field[` + i + `][col]" class="form-control input-sm">
                    <option value="6">Half</option>
                    <option value="12">Full</option>
                </select>
            </div>
            
        </div>
        `;

        $('.all_fields').append(html);
    });

    $(document).on('click', '.removeField', function() {
        $(this).parents('.el_field').remove();
    });
</script>
<script src="{{asset('assets_backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script>
    $('.seo-switch').click(function(){
      if($(this).is(':checked')) {
        $("#"+$(this).data('type')+'_div').show(300);
      } else {
        $("#"+$(this).data('type')+'_div').hide(300);
      }
    });
    $('.add-canonical').on('click',function(){
        var html = `<div style="position:relative;margin-top:5px;"><input type="text" class="form-control" name="seo_meta[canonical][]">
                    <button type="button" class="btn btn-xs btn-danger remove-canonical" style="position:absolute;top:0px;right:5px;"><i class="fa fa-times"></i></button></div>`; 
        $(this).parents('.link-can').append(html);
    });
    $(document).on('click', '.remove-canonical', function(){
        $(this).parent().remove();
    });
</script>
@endsection