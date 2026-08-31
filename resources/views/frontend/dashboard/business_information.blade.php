@extends('layouts.frontend')
@section('title', 'My Adds | Batswana Goo')
@section('customStyles')
    <style>

        .full-bot-book {
            display: none;
        }
        .slug_message{
            padding: 0;
            font-size: 11px;
            margin: 0;
        }
        .v3-list-ql {}
        {{-- .noDedicate was the "you need a plan for a dedicated link" upsell message, no longer shown.
        .noDedicate{
            font-size:14px;
            color:#000000;
            text-align:center;
            padding:20px 0px;
            max-width:500px;
            margin:0 auto;
        }
        .noDedicate a{
            display: block;
            color: #fff;
            border-radius: 5px;
            padding: 5px 15px;
            background: #1eaf38;
            margin:0 auto;
            width: 130px;
            position: relative;
            top: 10px;
        }
        --}}
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
                <div class="col-sm-4">
                    @include('frontend.dashboard.profile_nav')
                </div><!-- sm4 -->
                <div class="col-sm-8 pl-3">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pds">
                                    <h3>Business information </h3>
                                    {{-- <label>Saved</label> --}}
                                </div>
                            </div>
                            <div class="panel-body">
                                <form action="{{ url('dashboard/business-information') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Business Name</legend>
                                            </div>
                                            <input type="text" value="{{ old('name') ?? $user->name }}" name="name"
                                                class="form-control">
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="d-name">
                                                <strong class="slugText">{{url('/')}}/brands/{{($user->slug)??'slug'}}</strong>
                                                <input type="text" placeholder="Type Your Slug" class="form-control checkslug slustext checkslug" name="slug" value="{{ old('slug') ?? $user->slug }}">
                                                <button type="button" class="editbtn"><span><i class="fa fa-edit"></i></span></button>
                                            </div>
                                            <p class="slug_message slustext"></p>
                                        </fieldset>
                                    </div>

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Do You Offer own Delivery?</legend></small>
                                            </div>
                                            <select class="form-control" name="own_delivery">
                                                <option value="Do you offer own delivery?"
                                                    {{ $user->own_delivery == 'Do you offer own delivery?' ? 'selected' : '' }}>
                                                    Do you offer own delivery?
                                                </option>
                                                <option value="Yes, for and additional fee"
                                                    {{ $user->own_delivery == 'Do you offer own delivery?' ? 'selected' : '' }}>
                                                    Yes, for and additional fee
                                                </option>
                                                <option value="No" {{ $user->own_delivery == 'No' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                        </fieldset>
                                    </div><!-- p-forme -->

                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>About Company</legend>
                                            </div>
                                            <textarea type="text" class="form-control" name="about_company">{{ old('about_company') ?? $user->about_company }}</textarea>
                                        </fieldset>
                                    </div>


                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Address</legend>
                                            </div>
                                            <textarea type="text" class="form-control" name="company_address">{{ old('about_company') ?? $user->company_address }}</textarea>
                                        </fieldset>
                                        <small><label><input type="checkbox" name="show_address_on_adds" value="1"
                                                    {{ $user->show_address_on_adds == 1 ? 'checked' : '' }} />
                                                Show this address on all my ads
                                            </label></small>
                                    </div>



                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Working hours</legend>
                                            </div>
                                            <div class="timss">
                                                <div class="t-left">
                                                    <small>Start Time</small>
                                                    <select class="form-control" name="working_time_start">
                                                        <option value="01:00 AM"
                                                            {{ $user->working_time_start == '01:00 AM' ? 'selected' : '' }}>
                                                            01:00 AM
                                                        </option>
                                                        <option value="02:00 AM"
                                                            {{ $user->working_time_start == '01:00 AM' ? 'selected' : '' }}>
                                                            02:00 AM</option>
                                                        <option
                                                            value="03:00 AM"{{ $user->working_time_start == '03:00 AM' ? 'selected' : '' }}>
                                                            03:00 AM</option>
                                                        <option
                                                            value="04:00 AM"{{ $user->working_time_start == '04:00 AM' ? 'selected' : '' }}>
                                                            04:00 AM</option>
                                                        <option
                                                            value="05:00 AM"{{ $user->working_time_start == '05:00 AM' ? 'selected' : '' }}>
                                                            05:00 AM</option>
                                                        <option
                                                            value="06:00 AM"{{ $user->working_time_start == '06:00 AM' ? 'selected' : '' }}>
                                                            06:00 AM</option>
                                                        <option
                                                            value="07:00 AM"{{ $user->working_time_start == '07:00 AM' ? 'selected' : '' }}>
                                                            07:00 AM</option>
                                                        <option
                                                            value="08:00 AM"{{ $user->working_time_start == '08:00 AM' ? 'selected' : '' }}>
                                                            08:00 AM</option>
                                                        <option
                                                            value="09:00 AM"{{ $user->working_time_start == '09:00 AM' ? 'selected' : '' }}>
                                                            09:00 AM</option>
                                                        <option
                                                            value="10:00 AM"{{ $user->working_time_start == '10:00 AM' ? 'selected' : '' }}>
                                                            10:00 AM</option>
                                                        <option
                                                            value="11:00 AM"{{ $user->working_time_start == '11:00 AM' ? 'selected' : '' }}>
                                                            11:00 AM</option>
                                                        <option
                                                            value="12:00 AM"{{ $user->working_time_start == '12:00 AM' ? 'selected' : '' }}>
                                                            12:00 AM</option>
                                                    </select>
                                                </div>
                                                <div class="t-right">
                                                    <small>End Time</small>
                                                    <select class="form-control" name="working_time_end">
                                                        <option value="01:00 PM"
                                                            {{ $user->working_time_end == '12:00 PM' ? 'selected' : '' }}>
                                                            01:00 PM</option>
                                                        <option
                                                            value="02:00 PM"{{ $user->working_time_end == '02:00 PM' ? 'selected' : '' }}>
                                                            02:00 PM</option>
                                                        <option
                                                            value="03:00 PM"{{ $user->working_time_end == '03:00 PM' ? 'selected' : '' }}>
                                                            03:00 PM</option>
                                                        <option
                                                            value="04:00 PM"{{ $user->working_time_end == '04:00 PM' ? 'selected' : '' }}>
                                                            04:00 PM</option>
                                                        <option
                                                            value="05:00 PM"{{ $user->working_time_end == '05:00 PM' ? 'selected' : '' }}>
                                                            05:00 PM</option>
                                                        <option
                                                            value="06:00 PM"{{ $user->working_time_end == '06:00 PM' ? 'selected' : '' }}>
                                                            06:00 PM</option>
                                                        <option
                                                            value="07:00 PM"{{ $user->working_time_end == '07:00 PM' ? 'selected' : '' }}>
                                                            07:00 PM</option>
                                                        <option
                                                            value="08:00 PM"{{ $user->working_time_end == '08:00 PM' ? 'selected' : '' }}>
                                                            08:00 PM</option>
                                                        <option
                                                            value="09:00 PM"{{ $user->working_time_end == '09:00 PM' ? 'selected' : '' }}>
                                                            09:00 PM</option>
                                                        <option
                                                            value="10:00 PM"{{ $user->working_time_end == '10:00 PM' ? 'selected' : '' }}>
                                                            10:00 PM</option>
                                                        <option
                                                            value="11:00 PM"{{ $user->working_time_end == '11:00 PM' ? 'selected' : '' }}>
                                                            11:00 PM</option>
                                                        <option
                                                            value="12:00 PM"{{ $user->working_time_end == '12:00 PM' ? 'selected' : '' }}>
                                                            12:00 PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="checkTime">
                                                <ul>
                                                    @php
                                                        $workingDays = $user->working_day ?? [];
                                                    @endphp
                                                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                                        <li>
                                                            <label class="containercks">
                                                                <input type="checkbox" name="working_day[]" value="{{ $day }}" {{ in_array($day, $workingDays) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                                <b>{{ $day }}</b>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </fieldset>

                                    </div>



                                    <div class="p-forme">
                                        <button type="submit" class="sal-save">Saved</button>
                                    </div>

                                </form>
                            </div><!-- panl-body -->
                        </div>

                    </div>

                </div><!-- sm8 -->
            </div>
        </div>


    </div>
@endsection

@section('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.updFile', function() {
            $('.file-image').trigger('click');
        });

        $('.editbtn').on('click',function(){
            if($('.slustext').is(':visible')){
                $('.slustext').hide();
                $('.slugText').show();
            }else{
                $('.slugText').hide();
                $('.slustext').show();
            }
        });

        $(document).on('keyup', '.checkslug', function(){
            var slug = $(this).val();
            data = {_token:'{{csrf_token()}}', slug:slug}
            $.ajax({
                url: '{{ url('dashboard/checkslug') }}',
                type: 'POST',
                data: data,
                success: function(data) {
                    if(data.status == 1){
                        $('.slug_message').css('color','green');
                        $('.slug_message').html('This slug is available');
                    }else{
                        $('.slug_message').css('color','red');
                        $('.slug_message').html('Already taken.');
                    }
                }
            });
        })

        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $('.profile-image').attr('src', reader.result);
            }
            if (event.target.files[0] == undefined) {

            } else {
                reader.readAsDataURL(event.target.files[0]);
            }
        };

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
