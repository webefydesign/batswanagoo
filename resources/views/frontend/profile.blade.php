@extends('layouts.frontend')
@section('title', $user->name . ' | Batswana Goo')
@section('customStyles')
    <style>
    </style>
@endsection
@section('content')

    @php $general_meta = getConfigurations(); @endphp

    <section class="all-list-bre searchbanner"
        style="background-image: url('{{ $user->cover_image == null || empty($user->cover_image) ? url(getConfigurations()['myProfileBanner'] ?? asset('placeholder-cover.jpg')) : asset('uploads/profile/' . $user->cover_image) }}');">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="{{ url('/') }}">Back to Search</a>
                    </li>
                    <li><span>Profile Selling List</span>
                    </li>
                </ul>
                <h2 style="visibility: hidden;">My Profile</h2>
                <h1>Profile Selling List</h1>
            </div>
        </div>
    </section>

    <section class="profile_selling_list">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="set_bor_h">
                        @if(isset($user->image) && !empty($user->image))
                            <div class="my-avatar-img" style="background-image: url('{{ asset('uploads/profile/' . $user->image ?? '#') }}');"></div>
                        @else
                            <div class="my-avatar-img" style="background-image: url('{{ asset('placeholder-dp.jpg') }}');"></div>
                        @endif
                        <div class="seller-info">
                            <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <p>Selling for {{ $user->created_at->diffForHumans() }}</p>
                            <div class="seller-stats">
                                <div class="stats-ads">
                                    <p>Total Ads<span class="number">{{ $user->ads->count() }}</span></p>
                                </div>
                                <div class="stats-ads">
                                    <p>Active Ads<span class="number">{{ $user->activeAds->count() }}</span></p>
                                </div>
                            </div>
                            <div class="verification-badge desk-badge">
                                <div class="verification-item">
                                    <span class="badge-icon icon-badge-identity-verified"></span>
                                    <div>
                                        <h6 class="title">{{ getConfigurations()['web_name'] ?? '' }} Verified Seller</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="verification-badge mob-badge">
                        <div class="verification-item">
                            <span class="badge-icon icon-badge-identity-verified"></span>
                            <div>
                                <h6 class="title">{{ getConfigurations()['web_name'] ?? '' }} Verified Seller</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="f2">
                        <div class="vfilter"> <i class="material-icons ic1 " title="Grid view">apps</i>
                            <i class="material-icons ic2 act" title="List view">format_list_bulleted</i>
                            <i class="material-icons ic3" title="Map view">location_on</i>
                        </div>
                    </div>
                    <!-- LISTING INN FILTER -->

                    <!-- END LISTING INN FILTER -->
                    <!--ADS-->
                    <div class="s-ll">
                        <div class="sorts">
                            <label>Sort By</label>
                            <select name="sort" class="changeSort">
                                <option value="recent">Most Recent</option>
                                <option value="low_price">Low Prices</option>
                                <option value="high_price">High Prices</option>
                                <option value="call_for_price">Call For Price</option>
                                <option value="old">Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div class="ban-ati-com ads-all-list">
                        <a href="{{ url($general_meta['search']['adv_link_1'] ?? '#') }}"><span>Ad</span><img
                                src="{{ url($general_meta['search']['adv_image_1'] ?? '#') }}" alt="">
                        </a>
                    </div>
                    <!--ADS-->
                    <!-- Loader Image -->
                    <div id="loadingmessage" style="display:none">
                        <div id="loadingmessage1">&nbsp;</div>
                    </div>
                    <!-- Loader Image -->
                    <div class="all-list-sh all-listing-total list-render-html formobileProfile">
                        @if ($ads->count() > 0)
                            <ul>
                                @foreach ($ads as $ad_key => $ad)
                                    @php $img = ($ad->gallery->first())?$ad->gallery->first()->mobile_img:null; @endphp
                                    <li>
                                        <div class="eve-box">
                                            <!---LISTING IMAGE--->
                                            <div class="al-img"> <span class="open-stat">{{ $ad->gallery->count() }}
                                                    Photos</span>
                                                <a href="{{ url($ad->category->getSlug($ad->category->slug) . '/' . $ad->slug) }}">
                                                    <img src="{{ asset('uploads/post/' . $img ?? '#') }}" alt="">
                                                </a>
                                            </div>
                                            <!---END LISTING IMAGE--->
                                            <!---LISTING NAME--->
                                            <div>
                                                <h4>
                                                    <a href="{{ url($ad->category->getSlug($ad->category->slug) . '/' . $ad->slug) }}">
                                                        {{ $ad->title }}</a>
                                                </h4>
                                                @if ($ad->payment_type == 'amount' || $ad->payment_type == 'negotiable')
                                                    <h2>{{ formatPrice($ad->price) }}</h2>
                                                @else
                                                    <h2>Contact For Price</h2>
                                                @endif

                                                <p> {!! $ad->description !!} </p>

                                                <div class="links">
                                                    <span class="news-location">
                                                        <img src="{{ asset('assets_frontend/img/icon/3.png') }}">
                                                        {{ $ad->city }} - {{ $ad->created_at->diffForHumans() }}
                                                    </span>


                                                    <div class="dib">
                                                        @if (auth()->check() && $ad->wishlist == null)
                                                            <button class="wish addToList" data-id="{{ $ad->id }}">
                                                                <img alt=""
                                                                    src="{{ asset('assets_frontend/img/icon/svg/like.svg') }}">
                                                                Add to My List
                                                            </button>
                                                        @elseif(auth()->check())
                                                            <button class="wish addToList" data-id="{{ $ad->id }}">
                                                                <img alt=""
                                                                    src="{{ asset('assets_frontend/img/icon/svg/like.svg') }}">
                                                                Saved to List
                                                            </button>
                                                        @endif

                                                        <a href="https://wa.me/{{ $ad->phone }}" class="what"
                                                            target="_blank">Contact Seller</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---END LISTING NAME--->
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <nav aria-label="Page navigation example" class="navs">
                            @if ($ads->lastPage() != 1)
                                <ul class="pagination">
                                    @if ($ads->currentPage() != 1)
                                        <li class="page-item" onclick="filterAds(1)">
                                            <a class="page-link" href="javascript:void()" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                    @endif
                                    @for ($i = 1; $i <= $ads->lastPage(); $i++)
                                        <li class="page-item" onclick="filterAds('{{ $i }}')"><a
                                                class="page-link" href="javascript:void()">{{ $i }}</a></li>
                                    @endfor
                                    @if ($ads->currentPage() != $ads->lastPage())
                                        <li class="page-item" onclick="filterAds('{{ $ads->lastPage() }}')">
                                            <a class="page-link" href="javascript:void()" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </nav>
                    </div>

                    <!--ADS-->
                    <div class="ban-ati-com ads-all-list">
                        <a href="{{ url($general_meta['search']['adv_link_2'] ?? '#') }}"><span>Ad</span><img
                                src="{{ url($general_meta['search']['adv_image_2'] ?? '#') }}" alt="">
                        </a>
                    </div>
                    <!--ADS-->
                </div>
            </div>
        </div>
    </section>


@endsection

@section('customScripts')

    <script>
        var page = '{{ $_GET['page'] ?? '' }}';
        var sort = '{{ $_GET['sort'] ?? '' }}';

        $(document).on('change', '.changeSort', function(e) {
            e.preventDefault();
            var val = $(this).val();
            sort = val
            page = 1;
            filterAds(page);
        });

        var counter = 3;

        function filterAds(page) {
            $(document).ready(function() {

                var _url = 'profile/' + "{{ $user->id }}";
                var url = '';
                url += '?page=' + page,
                    url += (sort !== null && sort !== '') ? '&sort=' + sort : '',

                    window.history.pushState({
                        path: url
                    }, '', '/' + _url + url);

                $.ajax({
                    url: '/' + _url + url,
                    type: 'GET',
                    cache: false,
                    async: true,
                    success: function(data) {
                        $('.list-render-html').html(data.html);
                    },
                    error: function(error) {
                        counter--
                        if (counter > 0) {
                            filterAds(page);
                        }
                    }
                });
            });
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
                        $(_this).html('<img alt="" src="{{ asset('assets_frontend/img/icon/svg/like.svg') }}"> Saved to list');
                    } else {
                        $(_this).parents('.addt').removeClass('active');
                        $(_this).html('<img alt="" src="{{ asset('assets_frontend/img/icon/svg/like.svg') }}"> Add To My List');
                    }
                }
            })
        });
    </script>
@endsection
