@extends('layouts.frontend')
@section('title', 'My Adds | Batswana Goo')
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
                                    <h3>Change Password </h3>
                                    <!-- <label>Saved</label> -->
                                </div>
                            </div>
                            <div class="panel-body">

                                <form action="{{ url('dashboard/new-password') }}" method="post">
                                    {{ csrf_field() }}
                                    @if(isset(auth()->user()->password_reset) && date('Y-m-d H:i:s',strtotime(auth()->user()->password_reset.'+ 30 minute')) >= date('Y-m-d H:i:s'))
                                    
                                    @else
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Old Password</legend>
                                            </div>
                                            <input type="password" class="form-control" name="password">
                                        </fieldset>
                                    </div>
                                    @endif
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>New Password</legend>
                                            </div>
                                            <input type="password" class="form-control" name="new_password">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Re-type new password</legend>
                                            </div>
                                            <input type="password" class="form-control" name="confirmation_password">
                                        </fieldset>
                                    </div>



                                    <div class="p-forme">
                                        <button type="submit" class="sal-save">Change</button>
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
    </script>
@endsection
