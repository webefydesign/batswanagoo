@extends('layouts.frontend')

@section('title', 'Post Your Ads' . ' | Batswana Goo')

@push('push_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

        .login-reg {
            max-width: 400px;
            margin: 0 auto;
            margin-bottom: 70px;
            margin-top: 40px;
            border: solid 2px #1eaf38;
            border-radius: 5px;
            background: #f8fff9;
        }

        .error-msg {
            line-height: 16px;
            font-size: 12px;
            margin-top: 5px;
        }

        .google_btn {
            width: 100%;
            height: 50px;
            padding: 10px;
            text-align: center;
            color: #8d8d8d;
            background: white;
            border-radius: 4px;
            border: solid 1px #cacaca;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .google_btn img {
            width: 30px;
            margin-right: 10px;
        }

        .charCount {
            position: absolute;
            color: #1eaf38;
            font-size: 11px;
            bottom: 29px;
            z-index: 999;
            right: 10px;
        }

        .charCount2 {
            bottom: 8px !important;
            right: 22px !important;
        }

        .firstCategory{
            height: fit-content;
            position: relative;
        }

        .form-group{
            float: none !important;
        }

        .categoryMessage{
            font-size: 12px;
            position: absolute;
            bottom: -23px;
            margin: 0px;
        }
        button.prev-step, button.next-step {
            color: #fff;
            border-radius: 5px;
            margin-left: 0;
            padding: 4px 24px;
            background: #036dbf;
            cursor: pointer;
            font-weight: 600;
            font-size: 18px;
            border: none;
        }
        button.next-step {
            padding: 8px 27px;
            font-size: 20px;
            background: #1eaf38;
            margin-bottom: 10px;
            width: 90%;
        }
        button.next-step:disabled {
            background: #abc5b0;
        }
    </style>
@endpush

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="postss">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <div class="sub-tit">
                        <h2>Post an Add</h2>
                        <p>You are currently using the new experience for posting an ad! We are improving our design to help you post an ad faster and easier!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="whats">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h5>What are you posting an ad for?</h5>
                    <div class="cat-u">
                        <ul class="auto-ul">
                            @foreach ($mainCategories as $mainCate)
                                <li class="nav-item dropdown">
                                    <a href="javascript:void(0);"
                                        @if (count($mainCate->childrens) > 0) class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @else class="fatchCategory" data-id="{{ $mainCate->id }}" @endif
                                        data-name="{{ $mainCate->name }}"> {{ $mainCate->name }}
                                    </a>
                                    @if (count($mainCate->childrens) > 0)
                                        <div class="dropdown-menu">
                                            <ul>
                                                @foreach ($mainCate->childrens as $child)
                                                    <li><a data-id="{{ $child->id }}"
                                                            data-parent="{{ $mainCate->id }}"
                                                            class="fatchCategory dropdown-item"
                                                            href="javascript:void(0);"
                                                            data-name="{{ $child->name }}">{{ $child->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <span class="intentions-menu__tab-arrow"></span>
                                    @endif
                                </li>
                            @endforeach
                            <li><a href="javascript:void(0);" class="fatchCategory" data-id="other"
                                        data-name="Other Categories">All Other Categories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="post-text">
        <div class="container" style="border: 2px solid #1cae38;padding: 11px;margin-bottom: 10px;border-radius: 10px;">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3>You are now posting in <b class="nameCategory">{{ $firstMain['name'] ?? '' }}</b></h3>
                    <form action="{{ url('add-ads') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="postForm">
                            <!-- Form Step One -->
                            <div id="form-step-one">
                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Ad Title</label>
                                        <span>(Required)</span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="Type your add title" required value="{{ ($post->title)??'' }}" id="ad-title">
                                    <span class="error-msg" id="ad-title-error"></span>
                                    <small>Use keywords describing your item, like model, make, type, age, etc.</small>
                                </div>
                                <div class="firstCategory">
                                    @if (isset($_GET['like']) && $_GET['like'] != null)
                                        @php
                                            $post = getLikeAds($_GET['like']);
                                            $likeCategory = getLikeCategories($post->category_id);
                                            $fi = 0;
                                            $firstMain = ($likeCategory[$fi])??[];
                                        @endphp
                                        {{-- {{dd($likeCategory)}} --}}
                                        @if(isset($likeCategory[$fi]))
                                        @php $fi++; @endphp
                                        <div class="form-group" >
                                            <div class="labelTxt">
                                                <label>{{ $firstMain['name'] ?? '' }}'s Categories</label>
                                                <span>(Required)</span>
                                            </div>
                                            <input type="hidden" value="{{ $firstMain['id'] }}" name="category[0]">
                                            <select class="form-control fetchSubCategory"
                                                name="category[{{ $firstMain['id'] }}]"
                                                data-sub="sub_category_{{ $firstMain['id'] }}">
                                                <option value="" selected="">Select</option>
                                                @foreach ($firstMain->childrens as $child)
                                                    <option value="{{ $child->id }}" @if(isset($likeCategory[$fi]) && $likeCategory[$fi]['id']==$child->id) selected @endif>{{ $child->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="more_sub_category">
                                                @foreach($likeCategory as $lk => $firstMain)
                                                    @php $fi++; @endphp
                                                    @if($lk!=0 && isset($likeCategory[$fi]))
                                                    <div class="sub_category_{{ $firstMain->parent_id }}">
                                                        <select class="form-control fetchSubCategory"
                                                        name="category[{{ $firstMain['id'] }}]"
                                                        data-sub="sub_category_{{ $firstMain['id'] }}">
                                                            <option value="" selected="">Select</option>
                                                            @foreach ($firstMain->childrens as $child)
                                                                <option value="{{ $child->id }}" @if(isset($likeCategory[$fi]) && $likeCategory[$fi]['id']==$child->id) selected @endif>{{ $child->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @elseif (isset($firstMain))
                                        <div class="form-group" >
                                            <div class="labelTxt">
                                                <label>{{ $firstMain['name'] ?? '' }} Categories</label>
                                                <span>(Required)</span>
                                            </div>
                                            <input type="hidden" value="{{ $firstMain['id'] }}" name="category[0]">
                                            <select class="form-control fetchSubCategory"
                                                name="category[{{ $firstMain['id'] }}]"
                                                data-sub="sub_category_{{ $firstMain['id'] }}" required>
                                                <option value="" selected="">Select</option>
                                                @foreach ($firstMain->childrens as $child)
                                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="more_sub_category">
                                                <div class="sub_category_{{ $firstMain['id'] }}"></div>
                                            </div>
                                        </div>
                                    @endif
                                    <p class="categoryMessage"></p>
                                </div>
                                <button type="button" class="next-step" disabled>Next</button>
                            </div>
                            <!-- END Form Step One -->
                            <!-- Form Step Two -->
                            <div id="form-step-two" style="display: none;">
                                <div class="category_field_html">
                                    @include('frontend.includes.category_fields', [
                                        'category' => $firstMain,
                                    ])
                                </div>                            
                                
                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Location</label>
                                        <span>(Required)</span>
                                    </div>
                                    <input type="hidden" name="country" value="198">
                                    {{-- <select class="form-control fetchLocation autoSelectCountry" name="country" required data-location="state" style="visibility: hidden;">
                                        <option value="" disabled selected style="display:none">Select a Country</option>
                                        @foreach (getCountries() as $k => $country)
                                            <option value="{{ $country }}" @if(isset($post->country) && $post->country === $k) selected @endif>{{ $k }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select class="form-control fetchLocation stateSelect" name="state" required data-location="city">
                                        <option value="" selected disabled>Select a State</option>
                                        @foreach (getStatesByCountryName('Botswana') as $k => $state)
                                            <option value="{{ $state->id }}" @if(isset($post->state) && $post->state === $state->name) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                        {{-- @if(isset($post->country))
                                            @foreach (getStatesByCountryName($post->country) as $k => $state)
                                                <option value="{{ $state->id }}" @if(isset($post->state) && $post->state === $state->name) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        @endif --}}
                                    </select>
                                    <select class="form-control citySelect" name="city" required>
                                        <option value="" selected disabled>Select a City</option>
                                        @if(isset($post->country) && isset($post->state))
                                            @foreach (getCitiesByStateName($post->state, $post->country) as $k => $city)
                                                <option value="{{ $city->id }}" @if(isset($post->city) && $post->city === $city->name) selected @endif>{{ $city->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Description</label>
                                        <span>(Required)</span>
                                    </div>
                                    <textarea rows="4" cols="50" name="description" class="form-control" placeholder="Type a detailed desciption here..." required></textarea>
                                    <small>A detailed description of your item will increase your chances of selling.</small>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="labelTxt">
                                            <label>Payment Type</label>
                                            <span>(Required)</span>
                                        </div>
                                        <select class="form-control paymentType" name="payment_type">
                                            <option value="free">Free</option>
                                            <option value="amount">Amount</option>
                                            <option value="negotiable">Negotiable</option>
                                            <option value="contact">Contact For Price</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="labelTxt">
                                                <label>Price</label>
                                                <span>(Required)</span>
                                            </div>
                                            <!--<span class="charCount"><span>0</span>/15</span>-->
                                            <div class="currency_input">
                                                <div class="currency_s"> {{ baseSymbol() }} </div>
                                                <input type="number" name="price"
                                                    class="form-control" disabled
                                                    placeholder="Your Selling Price" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Phone</label>
                                        <span>(Required)</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Type Your Phone No" name="phone" required />
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Pictures</label>
                                        <span>(Required)</span>
                                    </div>
                                    <div class="img_validation">
                                        <ul>
                                            <li><small>* Image extension must be jpg, jpeg, webp or png<small></li>
                                            <li><small>* Image size must be lower then 5mb<small></li>
                                        </ul>
                                    </div>
                                    <ul class="filtype">
                                        @for ($i = 0; $i <= 15; $i++)
                                            <li class="fg_file">
                                                <label class="file-input" for="file-input-{{ $i }}">
                                                    <img src="{{ asset('assets_frontend/img/cameras.png') }}"
                                                        class="defaultimg" />
                                                    <input id="file-input-{{ $i }}" class="pickImage"
                                                        name="images[]" onchange="loadFile(event)" type="file" />
                                                </label>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label>Promote my add</label>
                                    @if(isset($promotes))
                                        @foreach ($promotes as $promo)
                                            <div class="addDd">
                                                <h3>{{ $promo['name'] }}</h3>
                                                <p>{!! $promo['description'] !!}</p>
                                                <div class="lavelsDiv check_ticks">
                                                    @if (isset($promo->promote) && count($promo->promote) > 0)
                                                        @foreach ($promo->promote as $pro)
                                                            <label class="containerbtn check_add"
                                                                data-promo_id="{{ $promo->id }}"
                                                                data-price="{{ $pro['price'] }}"
                                                                data-days="{{ $pro['days'] }}">
                                                                <small>{{ $pro['days'] }} Days</small>
                                                                <strong>{{ baseSymbol() }} {{ $pro['price'] }}</strong>
                                                                <span class="checkmarkBox"><em>Add</em><b
                                                                        class="fachek">&#10003;</b></span>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
    
                                        <div class="form-group text-center mt-4">
                                            <div class="activePromo">
    
                                            </div>
                                            <button type="button" class="prev-step">Previous</button>
                                            <button type="submit" class="postbtn">Post (Free)</button>
    
                                            <p style="margin-top: 20px;font-size: 12px;width: 80%;margin-left: 10%;display: none;color: red;"
                                                class="upgradePlan">
                                                You do not have access to this category <a class="UpgradeUrl" href="{{ url('select_plantype') }}">Upgrade
                                                    your Plan</a>
                                            </p>
                                            <p style="margin-top: 20px;font-size: 12px;width: 80%;margin-left: 10%; ">
                                                By clicking on Post Ad, you accept the <a href="{{ url('terms-of-use') }}">Terms of Use</a>, confirm that you will
                                                abide by the Safety Tips, and declare that this posting does not include any
                                                Prohibited Items.
                                            </p>
                                        </div>
    
                                    @endif
                                </div>                                
                            </div>
                            <!-- END Form Step Three -->
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>

@endsection

@section('customScripts')
<script>
    $(document).on('focusout', '#ad-title', function() {
        var title = $(this).val();
        $('#ad-title').css('border-color', '#1eaf38');
        var data = {
            _token: '{{ csrf_token() }}',
            title: title
        };
        $.ajax({
            url: "{{ route('checkDuplicateAd') }}",
            type: 'POST',
            data: data,
            success: function(res) {
                if(res.status == 1){
                    $('#ad-title').css('border-color', 'red');
                    $('#ad-title-error').html('<span style="color: red;">' + res.message + '</span><br />');
                } else {
                    $('#ad-title').css('border-color', '#1eaf38');
                    $('#ad-title-error').html('');
                }
                validateStepOne();
            }
        });
    });
    $(document).on('click', '.next-step', function() {
        $('#form-step-one').slideUp();
        $('#form-step-two').slideDown();
    });
    $(document).on('click', '.prev-step', function() {
        $('#form-step-two').slideUp();
        $('#form-step-one').slideDown();
    });

    $(document).on('input', '#ad-title', function () {
        validateStepOne();
    });

    function validateStepOne() {
        let isValid = true;

        const title = $('#ad-title').val().trim();
        const titleError = $('#ad-title-error').text().trim();

        if (title === '' || titleError !== '') {
            isValid = false;
        }

        $('#form-step-one select:visible').each(function () {
            if ($(this).val() === '' || $(this).val() === null) {
                isValid = false;
                return false;
            }
        });

        $('.next-step').prop('disabled', !isValid);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        var globle_category_id = 0;
        $(document).on('click', '.fatchCategory', function() {
            validateStepOne();
            var id = $(this).attr('data-id');
            var pid = $(this).attr('data-parent');
            nameCategory = $(this).attr('data-name');
            $('.nameCategory').html(nameCategory);
            $("html, body").animate({
                scrollTop: $('.post-text').offset().top - 100
            }, 100);
            if (globle_category_id != id) {
                data = {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    pid: pid
                };
                $.ajax({
                    url: '{{ route('fetchCategory') }}',
                    type: 'POST',
                    data: data,
                    success: function(res) {
                        $('.firstCategory').html(res.html);
                        $('.fetchSubCategory').trigger('change');
                        $('.select_2').select2();
                        console.log(res);
                        if (res.status == 0) {

                            if(res.msg != null && res.msg != ''){
                                $('.categoryMessage').remove();
                                $('.firstCategory').append( '<p class="categoryMessage" style="color: red;">' + res.msg + '</p>');
                                $('.status_msg').html('<div class="alert alert-danger">' + res.msg + '</div>');
                            }

                            $('.postbtn').attr("disabled", true);
                            $('.upgradePlan').show();

                        } else {

                            $('.postbtn').removeAttr("disabled");
                            $('.upgradePlan').hide();
                            if(res.msg != null && res.msg != ''){
                                $('.categoryMessage').remove();
                                $('.firstCategory').append( '<p class="categoryMessage" style="color: green;">' + res.msg + '</p>');
                                $('.status_msg').html( '<div class="alert alert-success">' + res.msg + '</div>' );
                            }


                        }
                        validateStepOne();

                        setTimeout(() => {
                            $('.alert-success').fadeOut(300);
                            $('.alert-danger').fadeOut(300);
                        }, 5000);
                    }
                })
            }
        });

        $(document).on('change', '.fetchSubCategory', function() {
            validateStepOne();
            var id = $(this).val();
            var sub = $(this).attr('data-sub');
            var data = {
                _token: '{{ csrf_token() }}',
                id: id
            };
            $('.category_field_html').html('<div class="fetching_fields"> Please wait, Fetching fields ... </div>');
            if (id != null && id != '') {
                $.ajax({
                    url: '{{ route('fetchSubCategory') }}',
                    type: 'GET',
                    data: data,
                    success: function(res) {
                        if ($('.' + sub).length == 0) {
                            $('.more_sub_category').append('<div class="' + sub + '"></div>');
                        }
                        $('.more_sub_category').find('.' + sub).html(res.categories);
                        $('.category_field_html').html(res.category_fields);
                        $('.select_2').select2({
                            closeOnSelect : false
                        });
                        if (res.status == 0) {
                            if(res.msg != null && res.msg != ''){
                                $('.categoryMessage').remove();
                                $('.firstCategory').append( '<p class="categoryMessage" style="color: red;">' + res.msg + '</p>');
                            }

                            $('.status_msg').html( '<div class="alert alert-danger">' + res.msg + '</div>' );
                            $('.postbtn').attr("disabled", true);
                            $('.upgradePlan').show();
                            $('.upgradePlan').find('.UpgradeUrl').attr('href',res.plan_url);


                        }
                        if (res.status == 1) {
                            $('.postbtn').removeAttr("disabled");
                            $('.upgradePlan').hide();
                            if(res.msg != null && res.msg != ''){
                                $('.categoryMessage').remove();
                                $('.firstCategory').append( '<p class="categoryMessage" style="color: green;">' + res.msg + '</p>');
                            }
                            $('.status_msg').html( '<div class="alert alert-success">' + res.msg + '</div>' );
                        }
                        validateStepOne();

                        setTimeout(() => {
                            $('.alert-success').fadeOut(300);
                            $('.alert-danger').fadeOut(400);
                        }, 3000);

                    }
                })
            } else {
                $('.category_field_html').html('');
                var n_sub = [sub];
                var tsub = sub;

                for (let i = 0; i < 5; i++) {
                    if ($('.' + tsub).length != 0) {
                        tsub = $('.' + tsub).find('select').attr('data-sub');
                        n_sub.push(tsub);
                    }
                }

                $.each(n_sub, function(l, v) {
                    $('.' + v).html('');
                });
            }
        });

        $(document).on('change', '.fetchLocation', function() {
            var id = $(this).val();
            var location = $(this).attr('data-location');
            if(location === 'state'){
                var url = '{!! url("get-states") !!}/'+id;
            }else{
                var url = '{!! url("get-cities") !!}/'+id;
            }
            var data = {
                id: id
            };
            if (id != null && id != '') {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    success: function(res) {
                        var html = `<option value="" selected disabled style="display:none">Select a ${location}</option>`;
                        if (location == 'state') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}">${value}</option>`;
                            });
                            $('.stateSelect').html(html);
                        } else if (location == 'city') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}">${value}</option>`;
                            });
                            $('.citySelect').html(html);
                        }
                    }
                })
            } else {
                var html = `<option value="" selected disabled>Select</option>`;
                if (location == 'state') {
                    $('.stateSelect').html(html);
                    $('.citySelect').html(html);
                } else if (location == 'city') {
                    $('.citySelect').html(html);
                }
            }
        });

        $(document).on('change', '.paymentType', function() {
            var val = $(this).val();
            if (val == 'amount' || val == 'negotiable') {
                $('[name="price"]').removeAttr('disabled');
            } else {
                $('[name="price"]').attr('disabled', 'disabled');
            }
        });

        $(document).on('change', '.fetchMakeModels', function() {
            var id = $(this).find('option:selected').attr('data-id');
            var data = {
                _token: '{{ csrf_token() }}',
                id: id
            };
            if (id != null && id != '') {
                $.ajax({
                    url: '{{ route('fetchMakeModels') }}',
                    type: 'POST',
                    data: data,
                    success: function(res) {
                        $('.makeModels').html(res.models);
                    }
                })
            } else {
                $('.makeModels').html('');
            }
        });

        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $(event.target).parent().find('img').attr('src', reader.result);
            };
            if (event.target.files[0] == undefined) {} else {
                reader.readAsDataURL(event.target.files[0]);
            }
        };

        $('.check_ticks .containerbtn').on('click', function() {
            if (!$(this).hasClass('activeDays')) {
                $(this).parent().find('.containerbtn').removeClass("activeDays");
                $(this).addClass("activeDays");
            } else {
                $(this).removeClass("activeDays");
            }
            calcPromoPrice();
        });

        function calcPromoPrice() {
            var price = 0;
            var inputs = ``;
            $('.activePromo').html('')
            $('.activeDays').each(function(k, v) {
                var p = $(v).attr('data-price');
                var id = $(v).attr('data-promo_id');
                var days = $(v).attr('data-days');
                inputs += `<input type="hidden" name="promo[` + k + `][id]" value="` + id + `">`;
                inputs += `<input type="hidden" name="promo[` + k + `][days]" value="` + days + `">`;
                inputs += `<input type="hidden" name="promo[` + k + `][price]" value="` + p + `">`;
                price += +p;
            });
            if (price == 0) {
                $('.postbtn').html('Post (Free)');
            } else {
                $('.postbtn').html('Post (NLE ' + price + ')');
                $('.activePromo').html(inputs);
            }
            return price;
        }

    </script>
@endsection