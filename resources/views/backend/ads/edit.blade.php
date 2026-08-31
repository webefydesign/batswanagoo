@extends('layouts.backend')
@section('title', 'Edit Ad')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/css/bootstrap-tagsinput.css')}}" />
<style>
    .img_validation {
        background: #fff9ea;
        padding: 5px 10px;
        margin-bottom: 10px;
        font-size: 10px;
    }

    .fetching_fields {
        font-size: 13px;
        padding: 0px 0px 30px 0px;
    }

    .currency_input {
        position: relative;
    }

    .currency_input input {
        padding-left: 60px;
    }

    .currency_s {
        position: absolute;
        width: 50px;
        height: 42px;
        background: #1eaf38;
        color: white;
        z-index: 1;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
        font-size: 22px;
    }

    .charCount {
        position: relative;
        color: #1eaf38;
        font-size: 11px;
        /* bottom: 29px;
        right: 10px; */
        z-index: 999;
    }

    .charCount2 {
        bottom: 8px !important;
        right: 22px !important;
    }

    .filtype {
        list-style: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .fg_file {
        border: 1px dashed #9d9d9d;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .fg_file:hover {
        border-color: #1eaf38;
    }

    .defaultimg {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 5px;
    }

    .file-input {
        cursor: pointer;
        display: block;
    }

    .file-input input[type="file"] {
        display: none;
    }
    .drag-box-content {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
    }
    .drag-box-content:hover {
        border-color: #1eaf38;
    }
    .drag-drop-box.dragging {
        border-color: #000;
        background: #f5f5f5;
    }
    #fileInputList li{
        position: relative;
    }
    .btn-remove-existing, .btn-remove-new {
        position: absolute;
        bottom: -20px;
        left: 0px;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">
                    Edit Ad
                </h1>
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{route('advertises.index')}}">Ads</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Edit Ad
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    @if ($errors->any())
        <div class="alert alert-danger alert-icon">
            <em class="icon ni ni-cross-circle"></em>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Ad: {{ $advertise->title }}</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('advertises.update', $advertise->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{$advertise->id}}" name="id">

                <div class="row">
                    <div class="col-md-8">
                        <!-- Category Selection -->
                        <div class="form-group">
                            <label for="category_id">Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($advertise->category_id == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ad Title -->
                        <div class="form-group">
                            <label for="title">Ad Title <span class="text-danger">*</span></label>
                            <span class="charCount"><span>0</span>/100</span>
                            <input type="text" name="title" class="form-control charCounting" id="title" data-char="100"
                                placeholder="Type your ad title" required value="{{$advertise->title}}">
                            <small class="form-text text-muted">Use keywords describing your item, like model, make, type, age, etc.</small>
                        </div>

                        <!-- Location -->
                        <div class="form-group">
                            <label for="state">Location <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-select fetchStates" name="state" id="state" data-location="city" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->name }}" @if($advertise->state == $state->name) selected @endif>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="city" class="form-select citySelect" id="city" required>
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->name }}" @if($advertise->city == $city->name) selected @endif>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <span class="charCount"><span>0</span>/500</span>
                            <textarea rows="4" cols="50" class="form-control charCounting" id="description" data-char="500" name="description"
                                placeholder="Type a detailed description here..." required>{{$advertise->description}}</textarea>
                            <small class="form-text text-muted">A detailed description of your item will increase your chances of selling.</small>
                        </div>

                        <!-- Payment Type and Price -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type <span class="text-danger">*</span></label>
                                    <select class="form-select paymentType" name="payment_type" id="payment_type">
                                        <option value="free" {{($advertise->payment_type == 'free')?'selected':''}}>Free</option>
                                        <option value="amount" {{($advertise->payment_type == 'amount')?'selected':''}}>Amount</option>
                                        <option value="negotiable" {{($advertise->payment_type == 'negotiable')?'selected':''}}>Negotiable</option>
                                        <option value="contact" {{($advertise->payment_type == 'contact')?'selected':''}}>Contact For Price</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <div class="currency_input">
                                        <div class="currency_s">{{ baseSymbol() }}</div>
                                        <input type="number" name="price" class="form-control" id="price"
                                            {{($advertise->payment_type != 'amount' && $advertise->payment_type != 'negotiable')?'disabled':''}} 
                                            value="{{$advertise->price}}" placeholder="Your Selling Price" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        {{-- <div class="form-group">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <span class="charCount"><span>0</span>/13</span>
                            <input type="text" name="phone" class="form-control charCounting" id="phone" data-char="13" 
                                placeholder="Your Phone No" value="{{$advertise->phone}}" required />
                        </div> --}}

                        <!-- Pictures -->
                        <div class="form-group">
                            <label for="pictures">Pictures <span class="text-danger">*</span></label>
                            <div class="img_validation">
                                <ul class="mb-2">
                                    <li>* Image extension must be jpg, jpeg, webp or png</li>
                                    <li>* Image size must be lower than 5mb</li>
                                </ul>
                            </div>
                            <div id="fileInputDragBox" class="drag-drop-box pt-4">
                                <div class="drag-box-content">
                                    <p>Drag & Drop your images here or click to upload</p>
                            
                                    <input id="file-input-1" type="file" name="images[]" multiple hidden accept="image/*" />
                                </div>
                            </div>
                            
                            <ul class="filtype pt-3" id="fileInputList">
                            
                                {{-- EXISTING IMAGES --}}
                                @foreach($advertise->gallery as $img)
                                    <li class="fg_file existing-image" data-id="{{ $img->id }}">
                                        <img src="{{ asset('uploads/post/'.$img->image) }}" class="defaultimg" />
                            
                                        <button type="button"
                                            class="btn-remove-existing btn-danger"
                                            data-id="{{ $img->id }}">
                                            Remove
                                        </button>
                                    </li>
                                @endforeach
                            
                            </ul>
                            
                            {{-- Hidden field to track deleted images --}}
                            <input type="hidden" name="deleted_images" id="deleted_images">
                            {{-- <ul class="filtype">
                                @foreach($advertise->gallery as $k=>$img)
                                    <li class="fg_file" style="border: 2px dashed green;">
                                        <label class="file-input" for="file-input-e{{ $k }}">
                                            <img src="{{ asset('uploads/post/'.$img->image) }}" class="defaultimg" />
                                            <input id="file-input-e{{ $k }}" class="pickImage" name="images[old][{{$img->id}}]" 
                                                value="{{$img->image}}" onchange="loadFile2(event)" type="file" accept="image/*" />
                                        </label>
                                    </li>
                                @endforeach
                                @for ($i = 0; $i <= (15 - count($advertise->gallery)); $i++)
                                    <li class="fg_file">
                                        <label class="file-input" for="file-input-{{ $i }}">
                                            <img src="{{ asset('assets_frontend/img/cameras.png') }}" class="defaultimg" />
                                            <input id="file-input-{{ $i }}" class="pickImage" name="images[new][]" 
                                                onchange="loadFile2(event)" type="file" accept="image/*" />
                                        </label>
                                    </li>
                                @endfor
                            </ul> --}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="active" {{($advertise->status == 'active')?'selected':''}}>Active</option>
                                <option value="pending" {{($advertise->status == 'pending')?'selected':''}}>Pending</option>
                                <option value="expired" {{($advertise->status == 'expired')?'selected':''}}>Expired</option>
                                <option value="sold" {{($advertise->status == 'sold')?'selected':''}}>Sold</option>
                            </select>
                        </div>

                        <!-- Current Images Preview -->
                        {{-- <div class="form-group">
                            <label for="current_images">Current Images</label>
                            <div class="row">
                                @foreach($advertise->gallery->take(4) as $img)
                                    <div class="col-3 mb-2">
                                        <img src="{{ asset('uploads/post/'.$img->image) }}" 
                                             class="img-fluid rounded img-thumbnail" style="max-height: 80px; width: 100%; object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="form-group text-center pt-5 pb-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fa fa-save me-1"></i> Update Ad
                    </button>
                    <a href="{{ route('advertises.index') }}" class="btn btn-secondary">
                        <i class="fa fa-times me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customScripts')
<script src="{{asset('assets_backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Character counting
        $('.charCounting').on('input', function() {
            var maxLength = $(this).data('char');
            var currentLength = $(this).val().length;
            var remaining = maxLength - currentLength;
            $(this).siblings('.charCount').find('span').text(currentLength);
        });

        // Initialize character counts
        $('.charCounting').each(function() {
            var currentLength = $(this).val().length;
            $(this).siblings('.charCount').find('span').text(currentLength);
        });

        // Payment type change
        $('.paymentType').on('change', function() {
            var val = $(this).val();
            if (val == 'amount' || val == 'negotiable') {
                $('[name="price"]').removeAttr('disabled');
            } else {
                $('[name="price"]').attr('disabled', 'disabled');
            }
        });

        // Image validation
        // $('.pickImage').on('change', function(e) {
        //     var img = $(this).val();
        //     if (img == null || img == '') {
        //         $(this).parents('.fg_file').css('border', '1px dashed #9d9d9d');
        //         $(this).parents('.fg_file').find('img').attr('src', '{{ asset("assets_frontend/img/cameras.png") }}');
        //         return false;
        //     }

        //     var ext = img.split(".").pop();
        //     var size = Math.round(($(this)[0].files[0].size / 1024));

        //     var all_clear = 1;
        //     if (['jpg', 'jpeg', 'webp', 'png'].includes(ext)) {} else {
        //         all_clear = 0;
        //     }
        //     if (size <= 5120) {} else {
        //         all_clear = 0;
        //     }

        //     if (all_clear == 1) {
        //         $(this).parents('.fg_file').css('border', 'dashed 2px green');
        //     } else {
        //         $(this).parents('.fg_file').css('border', 'dashed 2px red');
        //     }
        // });

        // Load file preview
        // window.loadFile2 = function(event) {
        //     var reader = new FileReader();
        //     reader.onload = function() {
        //         event.target.parentElement.querySelector('img').src = reader.result;
        //     };
        //     reader.readAsDataURL(event.target.files[0]);
        // };

        // State change handler
        $('.fetchStates').on('change', function() {
            var stateName = $(this).val();
            var citySelect = $('.citySelect');
            
            if (stateName) {
                // Fetch cities based on selected state
                $.ajax({
                    url: '{{ route("advertises.cities", "") }}/' + encodeURIComponent(stateName),
                    type: 'GET',
                    success: function(res) {
                        var html = '<option value="">Select City</option>';
                        $.each(res, function(index, value) {
                            html += '<option value="' + value.name + '">' + value.name + '</option>';
                        });
                        citySelect.html(html);
                        citySelect.prop('disabled', false);
                    },
                    error: function() {
                        citySelect.html('<option value="">Select City</option>');
                        citySelect.prop('disabled', false);
                    }
                });
            } else {
                citySelect.prop('disabled', true);
                citySelect.html('<option value="">Select City</option>');
            }
        });
    });
</script>
<script>
    let selectedFiles = [];
    let deletedImages = [];

    /* CLICK OPEN */
    $("#fileInputDragBox").on("click", function (e) {
        if ($(e.target).is("#file-input-1")) return;
        $("#file-input-1").trigger("click");
    });

    /* FILE CHANGE */
    $("#file-input-1").on("change", function (e) {
        addFiles(e.target.files);
    });

    /* DRAG */
    $("#fileInputDragBox").on("dragover", function (e) {
        e.preventDefault();
        $(this).addClass("dragging");
    });

    $("#fileInputDragBox").on("dragleave", function (e) {
        e.preventDefault();
        $(this).removeClass("dragging");
    });

    $("#fileInputDragBox").on("drop", function (e) {
        e.preventDefault();
        $(this).removeClass("dragging");
        addFiles(e.originalEvent.dataTransfer.files);
    });

    /* ADD NEW FILES */
    function addFiles(files) {

        Array.from(files).forEach(file => {
            if (!file.type.startsWith("image/")) return;
            selectedFiles.push(file);
        });

        renderAll();
    }

    /* RENDER ALL */
    function renderAll() {

        $("#fileInputList").find(".new-image").remove();

        let dt = new DataTransfer();

        selectedFiles.forEach((file, index) => {

            dt.items.add(file);

            let reader = new FileReader();

            reader.onload = function (e) {

                $("#fileInputList").append(`
                    <li class="fg_file new-image" data-index="${index}">
                        <img src="${e.target.result}" class="defaultimg" />

                        <button type="button" class="btn-remove-new btn-danger">
                            Remove
                        </button>
                    </li>
                `);
            };

            reader.readAsDataURL(file);
        });

        document.getElementById("file-input-1").files = dt.files;
    }

    /* REMOVE NEW FILE */
    $(document).on("click", ".btn-remove-new", function () {

        let index = $(this).closest(".fg_file").data("index");

        selectedFiles.splice(index, 1);

        renderAll();
    });

    /* REMOVE EXISTING IMAGE */
    $(document).on("click", ".btn-remove-existing", function () {

        let id = $(this).data("id");

        deletedImages.push(id);

        $("#deleted_images").val(JSON.stringify(deletedImages));

        $(this).closest(".fg_file").remove();
    });
</script>
@endsection
