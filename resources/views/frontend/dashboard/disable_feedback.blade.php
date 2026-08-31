@extends('layouts.frontend')
@section('title', 'My Adds | Salone Goo')
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
                                    <h3>Disable feedback </h3>
                                    <!-- <label>Saved</label> -->
                                </div>
                            </div>
                            <div class="panel-body chatss">


                                <form action="{{ url('dashboard/disable-feedback') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="p-forme">
                                        <fieldset class="rmlabel">
                                            <div class="rmD">
                                                <label>Receive and show feedback</label>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label
                                                        class="btn btn-secondary {{ $user->feedback == 0 ? 'active' : '' }}">
                                                        <input type="radio" name="feedback" id="option1" value="0"
                                                            {{ $user->feedback == 0 ? 'checked' : '' }}> Yes
                                                    </label>
                                                    <label
                                                        class="btn btn-secondary {{ $user->feedback == 1 ? 'active' : '' }}">
                                                        <input type="radio" name="feedback" id="option2" value="1"
                                                            {{ $user->feedback == 1 ? 'checked' : '' }}> No
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <hr>
                                        <p><small>Allow or disallow your customers to see feedback option on your Ads</small></p>
                                        <hr>
                                    </div>
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
    </script>
@endsection
