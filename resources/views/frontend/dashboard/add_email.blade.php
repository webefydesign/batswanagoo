@extends('layouts.frontend')
@section('title', 'Change Email | Batswana Goo')
@section('customStyles')
    <style>
        .alert-success {
            position: fixed;
            bottom: 10px;
            right: 30px;
            z-index: 999999;
            min-width: 400px;
            font-size: 13px;
            background: green;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .full-bot-book {
            display: none;
        }

        .v3-list-ql {}

        .resend_otp,
        .timeDiv {
            display: none;
        }

        .p-forme-div {
            margin-top: -18px;
            margin-bottom: -25px;
        }

        .back {
            font-size: 12px;
        }

        .time {
            font-size: 14px;
        }

        .resend_otp {
            font-size: 12px
        }

        .timeDiv {
            font-size: 12px
        }
    </style>
@endsection
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
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
                                    <h3>Update your email address below</h3>
                                    <label>Saved</label>
                                </div>
                            </div>
                            <div class="panel-body">

                                {{-- {{ dd(resetEmail()['time']) }} --}}
                                <form action="{{ url('dashboard/change-email') }}" method="post">
                                    {{ csrf_field() }}
                                    @if (resetEmail()['pending'] == 'pending')
                                        <div class="p-forme">
                                            <fieldset>
                                                <div class="pf-divs">
                                                    <legend>Enter OTP</legend>
                                                </div>
                                                <div class="fc-email">
                                                    <input type="number" name="otp" value="{{ old('otp') }}"
                                                        class="form-control">
                                                    <input type="hidden" name="change_email"
                                                        value="{{ resetEmail()['pending'] == 'pending' ? 'Done' : '' }}"
                                                        class="form-control">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="p-forme p-forme-div">
                                            <div class="timeDiv">Resend OTP After <span class="time"></span> minutes !
                                            </div>
                                            <a href="javascript:;" class="resend_otp">Resend
                                                OTP</a>
                                        </div>
                                        <div class="p-forme ">
                                            <a href="javascript:;" class="back">I don't want to change email</a>
                                        </div>
                                    @else
                                        <div class="p-forme">
                                            <fieldset>
                                                <div class="pf-divs">
                                                    <legend>Your Email</legend>
                                                </div>
                                                <div class="fc-email">
                                                    <input type="email" name="email"
                                                        value="{{ old('email') ?? $user->email }}" class="form-control">
                                                    <input type="hidden" name="change_email"
                                                        value="{{ resetEmail()['pending'] == 'Done' ? 'pending' : '' }}"
                                                        class="form-control">
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endif

                                    <div class="p-forme">
                                        <button type="submit" class="sal-save">Save</button>
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
        setTimeout(() => {
            $('.alert-success').fadeOut(300);
            $('.alert-danger').fadeOut(300);
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
        $(document).on('click', '.resend_otp', function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('dashboard/change-email') }}",
                data: {
                    'change_email': 'resendOTP'
                },
                type: 'post',
                success: function(result) {
                    location.reload();
                }
            });
        });
        $(document).on('click', '.back', function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('dashboard/change-email') }}",
                data: {
                    'change_email': 'cancelRequest'
                },
                type: 'post',
                success: function(result) {
                    location.reload();
                }
            });
        });
        var timer2 = "{!! resetEmail()['time'] !!}";
        console.log(timer2)
        if (timer2 != 0) {
            // $('.resend_otp').show();
            var interval = setInterval(function() {
                var timer = timer2.split(':');
                //by parsing integer, I avoid all extra string processing
                var minutes = parseInt(timer[0], 10);
                var seconds = parseInt(timer[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;
                if (minutes < 0) clearInterval(interval);
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;
                // minutes = (minutes < 10) ? minutes : minutes;
                $('.time').html(minutes + ':' + seconds);
                timer2 = minutes + ':' + seconds;
                if ((minutes * 1) == 0 && (seconds * 1) == 0) {
                    $('.resend_otp').show();
                    $('.timeDiv').hide();
                    clearInterval(interval);
                } else {
                    $('.timeDiv').show();
                    $('.resend_otp').hide();
                }
            }, 1000);
        } else {
            $('.resend_otp').show();
            $('.timeDiv').hide();
        }



        // };
    </script>
@endsection
