@extends('layouts.backend')
@section('title', 'Edit Promotion')
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
<form action="{{route('promote.update', $data['id'])}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Promotions
              </h1>
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('promote.index')}}">Promotions</a>
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
                <input type="text" name="name" class="form-control light-fields" id="page-title" placeholder="Title" required value="{{ ($data['name'])??'' }}">
                @csrf
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
                            <label for="">Description</label>
                            <textarea class="form-control input-sm" name="description">{{ ($data['description'])??'' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block block-rounded mt-3 pb-3">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Promote Days & Pricing</h3>
                        <a href="javascript:;" class="btn btn-sm btn-info" id="addMonth"><i class="fa fa-plus"></i> Add</a>
                    </div>
                    <div class="block-content">
                        <div class="row" id="allMonths">
                            @foreach($data['promote'] as $k => $promote)
                                <div class="row el_row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Day(s)</label>
                                            <input type="number" class="form-control input-sm" name="promote[{{ $k }}][days]" required value="{{ ($promote['days'])??'' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Price in (NLE)</label>
                                            <input type="number" class="form-control input-sm" name="promote[{{ $k }}][price]" required value="{{ ($promote['price'])??'' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-danger removeMonth btn-sm" style="margin-top: 24px;"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            @endforeach
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
                        <label>Day(s)</label>
                        <input type="number" class="form-control input-sm" name="promote[` + i + `][days]" required>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Price in (NLE)</label>
                        <input type="number" class="form-control input-sm" name="promote[` + i + `][price]" required>
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

    $(document).on('change', '[name="plan_type_id"]', function() {
        var id = $(this).val();
        $('#allPoints').html(''); $('#planCategories').html('');
        if(id != null && id != ''){
            $.ajax({
                url: '{{route("ajaxPlanPoints")}}',
                type: 'POST',
                data: {'_token':'{{csrf_token()}}', id:id},
                success: function(type){
                    $('#allPoints').html(type.points);
                    $('#planCategories').html(type.category);
                }
            });
        }
    });
</script>
@endsection
