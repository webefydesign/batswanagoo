@extends('layouts.backend')
@section('title', 'Create Plan')
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
<form action="{{route('plans.update', $data['id'])}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Plans
              </h1>
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('plans.index')}}">Plans</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  Edit 
                </li>
              </ol>
            </div>
            <button type="submit" class="btn btn-outline-success me-1 mb-3">
                <i class="fa fa-fw fa-save me-1"></i> Save
            </button>        
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Title" required value="{{$data['name']}}">
                @csrf
            </div>
            <div class="col-md-4">
                <div class="slug-field">
                    <input type="text" name="slug" class="form-control light-fields" id="page-slug" placeholder="Slug" required value="{{$data['slug']}}">
                    <a href="javscript:;" class="text-dark" id="generateSlug"><i class="fa fa-refresh"></i></a>
                </div>
            </div>
            {{-- Plan Type selection removed - ad posting no longer requires a plan type. --}}
        </div>
        </div>
    </div>
    
    <div class="content">
        <div class="row">
            <div class="col-md-12">
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
                                <input id="image" class="form-control input-sm" type="text" name="icon" value="{{$data['icon']}}">
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <input type="checkbox" name="dedicated_link" value="1" @if($data['dedicated_link']*1 === 1) checked @endif>
                                    <label>Dedicated Link</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <input type="checkbox" name="sms" value="1" @if($data['sms']*1 === 1) checked @endif>
                                    <label>SMS</label>

                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="form-group">
                                    <input type="checkbox" name="media_links" value="1" @if($data['media_links']*1 === 1) checked @endif>
                                    <label>Media Links</label>
                                </div>
                            </div> 
                        </div>              
                    </div>
                </div>
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Plan Months & Pricing</h3>
                        <a href="javascript:;" class="btn btn-sm btn-info" id="addMonth"><i class="fa fa-plus"></i> Add</a>
                    </div>
                    <div class="block-content">
                        <div class="row" id="allMonths">
                            @if(isset($data->getPlanPrice) && count($data->getPlanPrice) > 0)
                                @foreach($data->getPlanPrice as $k => $price)
                                    <div class="row el_row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Month(s)</label>
                                                <input type="number" class="form-control input-sm" name="plan[{{$k}}][month]" required value="{{ ($price->month)??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Price in (NLE)</label>
                                                <input type="number" class="form-control input-sm" name="plan[{{$k}}][price]" required value="{{ ($price->price)??'' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger removeMonth btn-sm" style="margin-top: 24px;"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row el_row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Month(s)</label>
                                            <input type="number" class="form-control input-sm" name="plan[0][month]" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Price in (NLE)</label>
                                            <input type="number" class="form-control input-sm" name="plan[0][price]" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-danger removeMonth btn-sm" style="margin-top: 24px;"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Plan's Points</h3>
                    </div>
                    <div class="block-content">
                        <div class="row" id="allPoints">
                            @php $k = 0; @endphp
                            @if(isset($data->planType->points) && count($data->planType->points) > 0)
                                @foreach($data->planType->points as $points)
                                    <div class="col-sm-12 el_row">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>{{$points}}</label>
                                                    <input type="text" class="form-control input-sm" name="points[{{$k}}][text]" value="{{ ($data['points'][$k]['text'])??'' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Options</label>
                                                    <select class="form-control input-sm" name="points[{{$k}}][include]">
                                                        <option value="text" @if(isset($data['points'][$k]['include']) && $data['points'][$k]['include'] === 'text') selected @endif>Show Text</option>
                                                        <option value="yes" @if(isset($data['points'][$k]['include']) && $data['points'][$k]['include'] === 'yes') selected @endif>Yes</option>
                                                        <option value="no" @if(isset($data['points'][$k]['include']) && $data['points'][$k]['include'] === 'no') selected @endif>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $k = $k + 1; @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- Categories/ad-limits removed - posting is unlimited now. --}}
        </div>
    </div>
</form>
@endsection
@section('customScripts')
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

    $(document).on('click', '#addMonth', function() {
        var i = Math.floor(Math.random() * 9000);
        var html = `
            <div class="row el_row mt-3">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Month(s)</label>
                        <input type="number" class="form-control input-sm" name="plan[` + i + `][month]" required>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Price in (NLE)</label>
                        <input type="number" class="form-control input-sm" name="plan[` + i + `][price]" required>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger removeMonth btn-sm"><i class="fa fa-times"></i></button>
                </div>
            </div>
        `;
        $('#allMonths').append(html);
    });
    $(document).on('click', '.removeMonth', function() {
        $(this).parents('.el_row').remove();
    });
</script>
@endsection