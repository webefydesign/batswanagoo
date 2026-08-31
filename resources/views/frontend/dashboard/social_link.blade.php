@extends('layouts.frontend')
@section('title', 'Social Link | Salone Goo')
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
                                    <h3> Social Link </h3>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form action="{{ url('dashboard/social-links') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Facebook Link</legend>
                                            </div>
                                            <input type="text" @if(old('facebook')) value="{{ old('facebook') }}" @elseif(isset($user->social_links->facebook)) value="{{ $user->social_links->facebook }}" @endif name="facebook"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Twitter Link</legend>
                                            </div>
                                            <input type="text" @if(old('twitter')) value="{{ old('twitter') }}" @elseif(isset($user->social_links->twitter)) value="{{ $user->social_links->twitter }}" @endif name="twitter"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Linked-In Link</legend>
                                            </div>
                                            <input type="text" @if(old('linkedin')) value="{{ old('linkedin') }}" @elseif(isset($user->social_links->linkedin)) value="{{ $user->social_links->linkedin }}" @endif name="linkedin"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Youtube Link</legend>
                                            </div>
                                            <input type="text" @if(old('youtube')) value="{{ old('youtube') }}" @elseif(isset($user->social_links->youtube)) value="{{ $user->social_links->youtube }}" @endif name="youtube"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Pinterest Link</legend>
                                            </div>
                                            <input type="text" @if(old('pinterest')) value="{{ old('pinterest') }}" @elseif(isset($user->social_links->pinterest)) value="{{ $user->social_links->pinterest }}" @endif name="pinterest"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>Instagram Link</legend>
                                            </div>
                                            <input type="text" @if(old('instagram')) value="{{ old('instagram') }}" @elseif(isset($user->social_links->instagram)) value="{{ $user->social_links->instagram }}" @endif name="instagram"
                                                class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="p-forme">
                                        <fieldset>
                                            <div class="pf-divs">
                                                <legend>TikTok Link</legend>
                                            </div>
                                            <input type="text" @if(old('tiktok')) value="{{ old('tiktok') }}" @elseif(isset($user->social_links->tiktok)) value="{{ $user->social_links->tiktok }}" @endif name="tiktok"
                                                class="form-control">
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
