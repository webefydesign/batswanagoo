@extends('layouts.frontend')
@section('title', 'My Adds | Batswana Goo')
@section('customStyles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/css/intlTelInput.css">
@php

    $profileFields = [
        'image'     => !empty($user->image),
        'name'      => !empty($user->name),
        'email'     => !empty($user->email),
        'phone'     => !empty($user->phone),
        'address'   => !empty($user->address),
        'state'     => !empty($user->state),
        'city'      => !empty($user->city),
        'gender'    => !empty($user->gender),
        'dob'       => !empty($user->dob),
        'cover_image'     => !empty($user->cover_image),
    ];

    $totalFields = count($profileFields);
    $completedFields = collect($profileFields)->filter()->count();
    $completionPercentage = round(($completedFields / $totalFields) * 100);

    $missingFields = [];

    $labels = [
        'image' => 'Profile Image',
        'state' => 'Province',
        'dob' => 'Date of Birth',
        'phone' => 'Phone Number',
    ];

    foreach ($profileFields as $field => $status) {
        if (!$status) {
            $missingFields[] = $labels[$field]
                ?? ucwords(str_replace('_', ' ', $field));
        }
    }

@endphp
    <style>
        .full-bot-book {
            display: none;
        }
        .v3-list-ql {}
        .cover-image-div {
            width: 400px;
        }
        .cover-image-div img {
            width: 400px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid;
        }
        .cover-image-div i {
            position: absolute;
            right: 30px;
            bottom: 110px;
        }
        @media screen and (max-width: 576px) {
            .cover-image-div { width: 100%; }
            .cover-image-div img { width: 100%; }
        }
        .profile-completion-card {
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:10px;
            padding:25px;
            margin-bottom:30px;
        }

        .profile-completion-card h4 {
            font-size: 16px;
            font-weight: bold;
        }
        .profile-completion-card .profile-desc {
            font-size: 13px;
        }

        .progress-circle{
            width:130px;
            height:130px;
            border-radius:50%;
            background:
            conic-gradient(
                #0066ff {{ $completionPercentage }}%,
                #edf1f7 0
            );
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
        }

        .progress-circle span{
            width:100px;
            height:100px;
            background:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            font-weight:700;
        }

        .custom-progress {
            height: 10px;
            background: #edf1f7;
            border-radius: 20px;
            overflow: hidden;
            margin: 15px 0 2px 0px;
        }

        .custom-progress-bar{
            height:100%;
            background:#0066ff;
            border-radius:20px;
        }

        .missing-box {
            background: #eae9e969;
            border: 1px solid #d1d1d1;
            padding: 8px;
            border-radius: 8px;
        }
        .missing-box strong {
            font-weight: 600;
            font-size: 13px;
        }

        .missing-box ul{
            margin-top:10px;
            padding: 0px;
        }

        .missing-box li{
            color: black;
            margin-bottom:5px;
            font-size: 12px;
            
        }

        .profile-lock-message{
            background:#f5f8ff;
            border:1px solid #d9e5ff;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        }
        .missing-box ul li span {
            border: 1px solid red;
            border-radius: 100%;
            padding: 0px 4px;
            margin-right: 2px;
            color: red;
            font-size: 10px;
            font-weight: bold;
        }
        .profile-alert small {
            border: 1px solid #606060;
            border-radius: 100%;
            padding: 0px 6px;
            margin-right: 2px;
            color: #353535;
            font-size: 12px;
            font-weight: bold;
        }
        .s-prf img {
            border: 1px solid #cecece;
            padding: 4px;
        }
        .s-prf .updFile {
            position: absolute;
            top: 49px;
            right: -3px;
            display: block;
            border-radius: 5px;
            background: #3a6ebf;
            padding: 2px 7px;
        }
        .s-prf .updFile img {
            width: 18px;
            height: auto;
            border-radius: 0 !important;
            border: none;
            padding: 0px !important;
            filter: brightness(20)
        }

        .s-prf .cover-updFile {
            position: absolute;
            top: 97px;
            right: -3px;
            display: block;
            border-radius: 5px;
            background: #3a6ebf;
            padding: 2px 7px;
        }
        .s-prf .cover-updFile img {
            width: 18px;
            height: auto;
            border-radius: 0 !important;
            border: none;
            padding: 0px !important;
            filter: brightness(20);
        }
        small.badge {
            font-size: 10px;
            font-weight: 100;
        }
        .iti {
            width: 100%;
        }
        .iti__selected-flag {
            pointer-events: none;
        }
        .iti__arrow {
            display: none;
        }
    </style>
@endsection
@section('content')

	@if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <div class="m-container forprfile">
        <div class="container">
            <div class="row">                
                <div class="col-sm-8 pl-3">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pds">
                                    <h3>Personal Details</h3>
                                </div>
                            </div>
                            <div class="panel-body">                                

                                <div class="profile-completion-card">

                                    <div class="row align-items-center">

                                        <div class="col-md-3 text-center">

                                            <div class="progress-circle">
                                                <span>{{ $completionPercentage }}%</span>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <h4>Complete your profile to unlock ad posting</h4>

                                            <p class="text-muted profile-desc">You're almost there! Complete the remaining information below to start posting ads.</p>

                                            <div class="custom-progress">
                                                <div class="custom-progress-bar"
                                                    style="width: {{ $completionPercentage }}%">
                                                </div>
                                            </div>

                                            @if($completionPercentage < 100)
                                                <small class="text-muted">
                                                    {{ $completedFields }} of {{ $totalFields }} fields completed.
                                                </small>
                                            @else
                                                <small class="text-success">
                                                    Profile completed. You are eligible to <a href="{{route('postAdd')}}">post ad</a>.
                                                </small>
                                            @endif

                                        </div>

                                        <div class="col-md-3">
                                            @if(count($missingFields))
                                            <div class="missing-box">
                                                <strong class="text-danger">Missing Information</strong>

                                                <ul>
                                                    @foreach($missingFields as $field)
                                                        <li> <span>!</span>{{ $field }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                                @if($completionPercentage < 100)
                                <div class="profile-alert alert alert-info">
                                    <small class="">i</small>
                                    <span>
                                        You can post ads only when your profile is
                                        <strong>100% complete.</strong>
                                    </span>
                                </div>
                                @endif
                                <div class="s-prf">
                                    @if(isset(auth()->user()->image) && !empty(auth()->user()->image))
                                        <img src="{{ asset('uploads/profile/' . (auth()->check() ? auth()->user()->image : ' ')) }}"
                                            class="profile-image">
                                    @else
                                        {{-- <img src="{{asset('placeholder-dp.jpg')}}" class="profile-image"> --}}
                                        <img src="{{asset('assets_frontend/fav.png')}}" class="profile-image">
                                    @endif
                                    <a href="javascript:;" class="updFile"><img src="{{asset('camera-icon.png')}}" alt="*"></a>                                    
                                </div>

                                <form action="{{ route('dashboard.profile') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <input type="file" name="image" class="file-image"
                                        style="visibility:hidden;position:absolute;z-index:-11;" onchange="loadFile(event, 'image')" accept="image/*">                                    
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>First Name</legend>
                                            </div>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') ?? $user->first_name }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Last Name</legend>
                                            </div>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ old('last_name') ?? $user->last_name }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Email</legend>
                                            </div>
                                            <input type="text" name="email" class="form-control"
                                                value="{{ old('email') ?? $user->email }}">
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Phone Number</legend>
                                                @if(empty($user->phone))
                                                <small class="badge badge-danger">required</small>
                                                @endif
                                            </div>
                                            <input id="phone" type="tel" name="phone" class="form-control"
                                                value="{{ old('phone') ?? $user->phone }}" placeholder="71 123 456" required>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Address</legend>
                                                @if(empty($user->address))
                                                <small class="badge badge-danger">required</small>
                                                @endif
                                            </div>

                                            <input type="text"
                                                name="address"
                                                class="form-control"
                                                value="{{ old('address') ?? $user->address }}"
                                                placeholder="Enter Address">
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Province / City</legend>
                                                @if(empty($user->state))
                                                <small class="badge badge-danger">required</small>
                                                @endif
                                            </div>
                                            <input type="hidden" name="country" class="form-control" value="Botswana" />
                                            {{-- <select class="form-control fatchStates autoSelectCountry" name="country" data-location="state"
                                                required>
                                                <option value="" selected disabled style="display:none">Select your country</option>
                                                @foreach (getCountries() as $c => $country)
                                                    <option value="{{ $country }}" @if(isset($user->country) && $user->country == $c) selected @endif>{{ $c }}</option>
                                                @endforeach
                                            </select> --}}
{{-- {{ dd($user->country) }} --}}                                            
                                            <div class="states-box">
                                                {{-- @if ($user->country != null) --}}
                                                    <select name="state" class="form-control fatchStates stateSelect"
                                                        data-location="city" required="">
                                                        @foreach(getStatesByCountryName('Botswana') as $state)
                                                            <option value="{{ $state->id }}" @if ($user->state == $state->name) selected @endif>{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                {{-- @endif --}}
                                            </div>
                                            <div class="cities-box">
                                                @if ($user->state != null)
                                                    <select name="city" class="form-control citySelect" required="">
                                                        @foreach(getCitiesByStateName($user->state, 'Botswana') as $city)
                                                        <option value="{{ $city->id }}" @if(isset($user->city) && $user->city == $city->name) selected @endif>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif(old('state') != null)
                                                    <select name="city" class="form-control citySelect" required="">
                                                        @foreach (getCitiesByStateName($user['state'] ?? old('state')) as $key => $city)
                                                            <option value="{{ $city }}"
                                                                @if (old('city') != null && old('city') == $user->city) selected @endif>
                                                                {{ $key }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select name="city" class="form-control citySelect" required="">
                                                        <option value="" selected disabled>Select a City</option>
                                                        @foreach (getCitiesByStateName($user['state'] ?? old('state'), 'Botswana') as $city)
                                                            <option value="{{ $city->id }}" @if ($user->city == $city->name) selected @endif>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <select name="city" class="form-control citySelect" required="">
                                                        <option value="" selected disabled>Select a City</option>
                                                        @foreach (getCitiesByStateName($user['state'] ?? old('state'), 'Botswana') as $city)
                                                            <option value="{{ $city->id }}" @if ($user->city == $city->name) selected @endif>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>

                                        </fieldset>
                                    </div><!-- p-forme -->

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Website URL</legend>
                                            </div>
                                            <input type="text" name="website" class="form-control"
                                                placeholder="Enter Your Website URL" value="{{ $user->website }}">
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Date of Birth</legend>
                                                @if(empty($user->dob))
                                                <small class="badge badge-danger">required</small>
                                                @endif
                                            </div>
                                            @php
                                                $dobValue = old('dob') ?? $user->dob;
                                                [$dobYear, $dobMonth, $dobDay] = $dobValue
                                                    ? array_pad(explode('-', $dobValue), 3, null)
                                                    : [null, null, null];
                                                $months = [
                                                    '01' => 'January', '02' => 'February', '03' => 'March',
                                                    '04' => 'April', '05' => 'May', '06' => 'June',
                                                    '07' => 'July', '08' => 'August', '09' => 'September',
                                                    '10' => 'October', '11' => 'November', '12' => 'December',
                                                ];
                                            @endphp
                                            <div style="display: flex; gap: 10px;">
                                                <select id="dobDay" class="form-control">
                                                    <option value="">Day</option>
                                                    @for ($d = 1; $d <= 31; $d++)
                                                        <option value="{{ sprintf('%02d', $d) }}" @selected($dobDay === sprintf('%02d', $d))>{{ $d }}</option>
                                                    @endfor
                                                </select>
                                                <select id="dobMonth" class="form-control">
                                                    <option value="">Month</option>
                                                    @foreach ($months as $num => $label)
                                                        <option value="{{ $num }}" @selected($dobMonth === $num)>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                <select id="dobYear" class="form-control">
                                                    <option value="">Year</option>
                                                    @for ($y = now()->year - 13; $y >= now()->year - 100; $y--)
                                                        <option value="{{ $y }}" @selected((string) $dobYear === (string) $y)>{{ $y }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <input type="hidden" name="dob" id="dobHidden" value="{{ $dobValue }}">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Gender</legend>
                                                @if(empty($user->gender))
                                                <small class="badge badge-danger">required</small>
                                                @endif
                                            </div>
                                            <select class="form-control" name="gender">
                                                <option value="male" @if($user['gender'] == 'male') selected @endif>Male</option>
                                                <option value="female" @if($user['gender'] == 'female') selected @endif>Female</option>
                                            </select>
                                        </fieldset>
                                    </div>

                                    {{-- <div class="p-forme b-btm">
                                        <fieldset class="rmlabel">
                                            <div class="rmD">
                                                <label style="font-size: 13px;font-weight: 500;"><img
                                                        src="{{ asset('assets_frontend/img/icon/seo.png') }}" />
                                                    Google</label>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-secondary ">
                                                        <input type="radio" name="google_login" id="goole_option1" > Yes
                                                    </label>
                                                    <label class="btn btn-secondary active">
                                                        <input type="radio" name="google_login" id="goole_option2"
                                                            checked="" > No
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme b-btm">
                                        <fieldset class="rmlabel">
                                            <div class="rmD">
                                                <label style="font-size: 13px;font-weight: 500;"><img
                                                        src="{{ asset('assets_frontend/img/icon/facebook.png') }}" />Facebook</label>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-secondary ">
                                                        <input type="radio" name="facebook_login" id="facebookoption1" >Yes
                                                    </label>
                                                    <label class="btn btn-secondary active">
                                                        <input type="radio" name="facebook_login" id="facebookoption2"
                                                            checked="" >No
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <label class="containerchecks dont">I don't want to receive newsletters and
                                                    promo offers from Batswana Goo
                                                    <input type="checkbox" name="subscribe" value="1"
                                                        @if ($user->subscriber != null) checked="checked" @endif>
                                                    <span class="checkmarkcontain"></span>
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Enter password to save changes</legend> <small>7 / 20</small>
                                            </div>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter your password" required>
                                        </fieldset>
                                    </div> --}}
                                    <input type="file" name="cover_image" class="cover-file-image"
                                        style="visibility:hidden;position:absolute;z-index:-11;" onchange="loadFile(event, 'cover_image')" accept="image/*">
                                    <div class="s-prf cover-image-div">
                                        @if(auth()->check() && auth()->user()->cover_image && !empty(auth()->user()->cover_image))
                                            <img src="{{ asset('uploads/profile/' . auth()->user()->cover_image) }}"
                                                class="cover-image">
                                        @else
                                            <img src="{{asset('placeholder-cover.jpg')}}"
                                                class="cover-image" />
                                        @endif
                                        <a href="javascript:;" class="cover-updFile"><img src="{{asset('camera-icon.png')}}" alt="*"></a>                                    
                                        {{-- <i class="fa fa-edit "></i> --}}
                                    </div>


                                    <div class="p-forme">
                                        <button type="submit" class="sal-save">Update</button>
                                    </div>

                                </form>
                            </div><!-- panl-body -->
                        </div>

                    </div>

                </div><!-- sm8 -->
                <div class="col-sm-4">
                    @include('frontend.dashboard.profile_nav')
                </div><!-- sm4 -->
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        // Phone field locked to Botswana, same as the contact form.
        $(document).ready(function () {
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                window.intlTelInput(phoneInput, {
                    initialCountry: 'bw',
                    onlyCountries: ['bw'],
                    separateDialCode: true,
                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js',
                });

                $(phoneInput).on('input', function () {
                    const validChars = /^[0-9]*$/;
                    if (!validChars.test(this.value)) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    }
                });
            }
        });

        $(document).on('click', '.updFile', function() {
            $('.file-image').trigger('click');
        });

        $(document).on('change', '#dobDay, #dobMonth, #dobYear', function() {
            var day = $('#dobDay').val();
            var month = $('#dobMonth').val();
            var year = $('#dobYear').val();
            $('#dobHidden').val((day && month && year) ? (year + '-' + month + '-' + day) : '');
        });

        $(document).on('click', '.cover-updFile', function() {
            $('.cover-file-image').trigger('click');
        });

        var loadFile = function(event, type='image') {
            var reader = new FileReader();
            reader.onload = function() {
                if (type == 'image') {
                    $('.profile-image').attr('src', reader.result);
                } else {
                    $('.cover-image').attr('src', reader.result);
                }
            }
            if (event.target.files[0] == undefined) {

            } else {
                reader.readAsDataURL(event.target.files[0]);
            }
        };
        setTimeout(() => {
            $('.alert-success').fadeOut(300);
        }, 3000);

        $('[data-toggle="tab"]').on('click', function() {
            var href = $(this).attr('href');
            $('.tab-pane').addClass('fade');
            $('.tab-pane').removeClass('show').removeClass('active');
            $(href).removeClass('fade');
            $(href + '-mob').removeClass('fade');
            $(href).addClass('show').addClass('active');
            $(href + '-mob').addClass('show').addClass('active');
        });

        @if($user->state==null)
        setTimeout(()=>{
            $('.autoSelectCountry').trigger('change');
        },500)
        @endif

        $(document).on('change', '.publish-ad', function() {
            var _this = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('publishAd') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res == 1) {
                        // $(_this).prop('checked', true);
                        $('.publishAd' + id).prop('checked', true);
                    } else {
                        $('.publishAd' + id).prop('checked', false);
                        // $(_this).prop('checked', false);
                    }
                }
            })
        });
        $(document).on('change', '.sold-ad', function() {
            var _this = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('publishAd') }}",
                type: 'POST',
                data: {
                    id: id,
                    sold: 1,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res == 1) {
                        // $(_this).prop('checked', true);
                        $('.soldAd' + id).prop('checked', true);
                    } else {
                        $('.soldAd' + id).prop('checked', false);
                        // $(_this).prop('checked', false);
                    }
                }
            })
        });
        $(document).on('change', '.fatchStates', function() {
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

        function deleteAd(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1eae38',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deletAd-' + id).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }
    </script>
@endsection
