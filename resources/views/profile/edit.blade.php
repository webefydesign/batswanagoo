@extends('layouts.frontend')
@section('title', 'Profile | ' . env('APP_NAME'))
@section('customStyles')
@endsection

@section('content')
    <section class="all-list-bre searchbanner" style="background-image: url('{{ url('assets_frontend/img/electronices.jpg') }}');">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="#">Back to Search</a>
                    </li>
                    <li><span>My Profile</span>
                    </li>
                </ul>
                <h2 style="visibility: hidden;">My Profile</h2>
                <h1>My Profile</h1>
            </div>
        </div>
    </section>

    <section class="flats">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li><a class="active" data-toggle="tab" href="#detail">Profile Details</a></li>
                        <li><a data-toggle="tab" href="#password">Password Setup</a></li>
                        <li><a data-toggle="tab" href="#verified">Verified Sellers</a></li>
                    </ul>

                    <div class="tab-content">

                        @if ($errors->updatePassword->all())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->updatePassword->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="detail" class="tab-pane fade active show">
                            <div class="profileDiv mt-3 mb-5">
                                <h3>Profile Image</h3>
                                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @method('patch')

                                    <div class="form-group">
                                        @if(isset($user->image))
                                            <div class="my-avatar-img" style="background-image: url({{ url('uploads/user_image/').'/'.$user->image }});"></div>
                                        @else
                                            <div class="my-avatar-img" style="background-image: url({{ url('assets_frontend/img/ic-11.png') }});"></div>
                                        @endif
                                    </div><!-- form-group -->
                                    <div class="form-group">
                                        <ul class="customs">
                                            <li>
                                                <button type="button" for="file-upload" class="custom-file-upload">
                                                    <i class="fa fa-cloud-upload"></i> Custom Upload
                                                    <input id="file-upload" type="file" name="image"/>
                                                </button>
                                            </li>
                                            {{-- <li>
                                                <button type="button" for="file-upload" class="custom-file-upload">
                                                    <i class="fa fa-cloud-upload"></i> Reset
                                                    <input id="file-upload" type="file"/>
                                                </button>
                                            </li> --}}
                                        </ul>
                                    </div><!-- form-group -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>First Name</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') ?? $user->first_name }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Last Name</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="text" name="last_name" class="form-control"
                                                value="{{ old('last_name') ?? $user->last_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Username</label>
                                        <input type="text" name="name" class="form-control"
                                                value="{{ old('username') ?? $user->name }}" required>
                                    </div><!-- form-group -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Email</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="text" name="email" class="form-control"
                                                value="{{ old('email') ?? $user->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Contact Details</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <select class="form-control" name="contact_detail" required>
                                                   <option value="" selected disabled style="display:none;">Select</option>
                                                   <option value="mobile" @if(isset($user->contact_detail) && $user->contact_detail === 'mobile') selected @endif>Mobile</option>
                                                   <option value="work" @if(isset($user->contact_detail) && $user->contact_detail === 'work') selected @endif>Work</option>
                                                   <option value="home" @if(isset($user->contact_detail) && $user->contact_detail === 'home') selected @endif>Home</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Enter Number</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="text" name="phone" class="form-control"
                                                value="{{ old('phone') ?? $user->phone }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        @php
                                            if(gettype($user->country) === 'string'){
                                                $country_id = ($user->country)??old('country')??NULL;
                                            }else{
                                                $country_id = ($user->country)*1??old('country')*1??NULL;
                                            }

                                            if(gettype($user->state) === 'string'){
                                                $state_id = ($user->state)??old('state')??NULL;
                                            }else{
                                                $state_id = ($user->state)*1??old('state')*1??NULL;
                                            }

                                            if(gettype($user->city) === 'string'){
                                                $city_id = ($user->city)??old('city')??NULL;
                                            }else{
                                                $city_id = ($user->city)*1??old('city')*1??NULL;
                                            }
                                        @endphp

                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Country</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <select class="form-control fatchStates autoSelectCountry" name="country" required data-location="state">
                                                    <option value="" selected disabled style="display:none;">Select</option>
                                                    @foreach (getCountries() as $k => $country)
                                                        <option value="{{ $country }}" @if(isset($country_id) && $country_id === $country) selected @endif>{{ $k }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>State</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <select class="form-control fatchStates stateSelect" name="state" required data-location="city">
                                                    <option value="" selected disabled>Select</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>City</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <select class="form-control citySelect" name="city" required>
                                                    <option value="" selected disabled>Select</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Website URL</label>
                                                    <!-- <span>(Required)</span> -->
                                                </div>
                                              <input type="text" name="website_url" class="form-control"
                                                placeholder="Enter Your Website URL" value="{{ $user->website_url }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="containerchecks">I don't want to receive newsletters and promo offers from Batswana Goo
                                                  <input type="checkbox" checked="checked">
                                                  <span class="checkmarkcontain"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div> --}}


                                    {{-- <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Enter password to save changes</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="text" name="" class="form-control" placeholder="Enter your password" value="">
                                                <div class="kitsleft">
                                                    <a href="#">Forgot Password</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="sav-ul">
                                                <li><button>Save</button>{{-- <button class="cancels">Cancel</button> --}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- profileDiv -->
                        </div>
                        <div id="password" class="tab-pane fade">
                            <!-- <h3>Password Setup</h3> -->
                            <div class="profileDiv mt-3 mb-5">
                                <h3>Password Setup</h3>
                                <h4>To update your password, please complete the fields below.</h4>
                                <p>In order to protect your account, make sure your password must contain at least 8 characters, with a combination of both letters and numbers</p>
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Current Password</label>
                                                    <!-- <span>(Required)</span> -->
                                                </div>
                                                <input type="password" name="current_password" class="form-control" placeholder="Current Password" autocomplete="current-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>New Password</label>
                                                    <!-- <span>(Required)</span> -->
                                                </div>
                                                <input type="password" name="password" class="form-control" placeholder="Enter New Password" autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group text-left">
                                                <div class="labelTxt">
                                                    <label>Re-enter New Password</label>
                                                </div>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <ul class="sav-ul ">
                                                <li style="justify-content: center;"><button>Update Password</button></li>
                                            </ul>
                                        </div>
                                    </div>




                                </form>
                            </div><!-- profileDiv -->
                        </div><!-- tab-pane -->
                        <div id="verified" class="tab-pane fade">

                            <div class="profileDiv mt-3 mb-5">
                               <h3>Verified Sellers</h3>

                               <p>Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customScripts')
    <script>

        @if($user->country!==null)
            setTimeout(()=>{
                $('.autoSelectCountry').trigger('change');

                @if($user->state!==null)
                    setTimeout(()=>{
                        $('.stateSelect').trigger('change');
                    },500)
                @endif
            },500)
        @endif

        $(document).on('change', '.fatchStates', function() {
            var id = $(this).val();
            var location = $(this).attr('data-location');
            if(location === 'state'){
                var url = '{!! url("get-states") !!}/'+id;
            }else{
                var url = '{!! url("get-cities") !!}/'+id;
            }
            var state_id = '{!! $state_id !!}';
            var city_id = '{!! $city_id !!}';
            var data = {
                id: id
            };
            if (id != null && id != '') {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    success: function(res) {
                        var html = `<option value="" selected disabled style="display:none">Select</option>`;
                        if (location == 'state') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}" ${state_id === index ? 'selected' : ''}>${value}</option>`;
                            });
                            $('.stateSelect').html(html);
                        } else if (location == 'city') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}" ${city_id === index ? 'selected' : ''}>${value}</option>`;
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

    </script>
@endsection
