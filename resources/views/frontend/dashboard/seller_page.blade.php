@extends('layouts.frontend')
@section('title', $user->name.' | Batswana Goo')
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

        .badgelabel {
            display: inline-block;
            max-width: 90px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }

        .pname {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }

        .pname img {
            height: 25px;
            width: 25px;
            object-fit: cover;
            text-align: center;
            object-position: center;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .edits:before {
            padding: 0;
        }

        .delets:before {
            padding: 0;
        }

        .viewss:before {
            padding: 0;
        }

        .edits:before {
            padding: 0;
        }
        .s--ul .li-status-online{
            top: 5px;
        }
    </style>
@endsection
@section('seo')
    <meta name="description" content="{{ Str::limit(strip_tags($user->about_company ?? ''), 125) }}">
    <meta property="og:title" content="{{$user->name ?? $user->first_name}} | Batswana Goo">
    <meta property="og:description" content="{{ Str::limit(strip_tags($user->about_company ?? ''), 125) }}">
    <meta property="og:url" content="{{route('shop',$user->slug)}}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{asset('uploads/profile/'.$user->image)}}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{$user->name ?? $user->first_name}} | Batswana Goo">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($user->about_company ?? ''), 125) }}">
    <meta name="twitter:image" content="{{asset('uploads/profile/'.$user->image)}}">
    <meta name="twitter:url" content="{{route('shop',$user->slug)}}">
@endsection
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <section class="all-list-bre searchbanner"
        style="background-image: url('{{ $user->cover_image == null || empty($user->cover_image) ? url(getConfigurations()['myProfileBanner'] ?? 'https://placehold.co/1140x286') : asset('uploads/profile/' . $user->cover_image) }}');">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="{{ url('/brands') }}">Back to Brands</a>
                    </li>
                    <li><span>{{$user['name']??$user['first_name']}}</span>
                    </li>
                </ul>
                <h2 style="visibility: hidden;">My Profile</h2>
                <h1>{{$user['name']??$user['first_name']}}</h1>
            </div>
        </div>
    </section>



    <div class="m-container forprfile" style="margin-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 mb-4">
                    @include('frontend.dashboard.seller_nav')
                </div><!-- sm4 -->
                <div class="col-sm-9">
                    <div class="all-list-sh all-listing-total">
                        <ul>
                            @foreach ($allAds as $ads)
                                @php  $img = ($ads->gallery[0]->mobile_img)??'#'; @endphp
                                <li>
                                    <div class="eve-box">
                                        <div class="al-img"> <span class="open-stat">3 Photos</span>
                                            <a href="{{ url(generateUrl($ads->category_id, 'category', $ads->slug)) }}">
                                                <img src="{{ asset('uploads/post/' . $img) }}" alt="no image">
                                            </a>
                                        </div>
                                        <div>
                                            <h4>
                                                <a href="{{ url(generateUrl($ads->category_id, 'category', $ads->slug)) }}">{{ $ads->title }}</a>
                                                <img src="" alt=""></i>
                                            </h4>
                                            <h2> {{ formatPrice($ads->price) }}</h2>
                                            <p>{!! $ads->description !!}</p>
                                            <div class="links">
                                                <span class="news-location"><img
                                                        src="{{ asset('assets_frontend/img/icon/3.png') }}">{{ $ads->city }}
                                                    -
                                                    {{ $ads->created_at->diffForHumans() }}</span>
                                                <div class="dib">
                                                    @if (auth()->check())
                                                        <button type="submit" class="wish addToList"
                                                            data-id="{{ $ads->id }}"><img alt=""
                                                                src="{{ asset('assets_frontend/img/icon/like.png') }}">
                                                            @if ($ads->wishlist != null)
                                                                Saved to List
                                                            @else
                                                                Add to my list
                                                            @endif
                                                        </button>
                                                    @endif

                                                    <a href="https://wa.me/{{ $ads->phone }}" class="what"
                                                        target="_blank">Contact
                                                        Seller</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!---END LISTING NAME--->
                                        <!---SAVE--->
                                        <span class="enq-sav" data-toggle="tooltip" title=" Click to like this listing">
                                            <i class="l-like sav-act"><img src="images/icon/svg/like.svg"
                                                    alt=""></i></span>
                                        <!---END SAVE--->
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
        $(document).on('click', '.addToList', function() {
            var _this = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('addToList') }}",
                type: 'POST',
                data: {
                    id: id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res == 1) {
                        $(_this).parents('.addt').addClass('active');
                        $(_this).html('Saved to list');
                    } else {
                        $(_this).parents('.addt').removeClass('active');
                        $(_this).html('Add To My List');
                    }
                }
            })
        });
    </script>
@endsection
