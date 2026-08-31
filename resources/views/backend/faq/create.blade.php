@extends('layouts.backend')
@section('title', 'Create FAQ')
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
    .select2-container--default .select2-selection--single{
        background: transparent;
        border: 2px solid #cecece;
        padding: 7px;
        border-radius: 12px;
        height: 50px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px;
    }
</style>
@endsection
@section('content')
<form action="{{route('faqs.store')}}" method="POST">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                FAQs
              </h1>
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('faqs.index')}}">FAQs</a>
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
            <div class="col-md-4">
                <input type="text" name="title" class="form-control light-fields" placeholder="Title" required>
                @csrf
            </div>
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
                        <div class="col-md-4 form-group pb-2">
                            <label for="category_id">Category</label>
                            <select class="form-control light-fields select2" name="category_id" required id="category_id">
                                @foreach (fetchCategories() as $cates)
                                    @include('frontend.includes.category_option', ['type'=>'search', 'meta' => null, 'cates'=>$cates, 'dash'=>'']);
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group pb-2">
                            <label for="category_id">Description</label>
                            <textarea name="description" class="form-control light-fields editor"></textarea>
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
<script src="https://cdn.tiny.cloud/1/zxhbf3x344fzo897fbfckxk8ntaz1ptnmemotgvsasf9e8ko/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $('.select2').select2({
        placeholder:'Select Any'
    });
    tinymce.init({
        selector: '.editor',
        plugins: 'anchor autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount media linkchecker code textcolor',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | link image media table | align lineheight | numlist bullist indent outdent | removeformat | code',
        menubar: false,
        file_picker_types: 'image',
        image_dimensions: false,
        relative_urls: false,
        remove_script_host: false,
        file_picker_callback: function(cb, value, meta) {
            var route_prefix = "/filemanager"; // Update it to your Laravel Filemanager URL
            window.open(route_prefix + '?type=' + meta.filetype, 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');
                // set the value of the desired input to image url
                cb(file_path, { alt: items[0].alt || '' });
            };
        }
    });
</script>
@endsection
