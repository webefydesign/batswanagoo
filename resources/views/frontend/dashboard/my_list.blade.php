@extends('layouts.frontend')
@section('title', 'My Wishlist | Batswana Goo')
@section('customStyles')
    <style>

        .all-list-sh .eve-box {
            display: flex;
            align-items: stretch;
        }
        .forprfile .container {
	background: none;
	border:none;
	padding: 30px;
	max-width: 1300px;
}
.forprfile .cr .container {padding:0;}
    </style>
@endsection
@section('content')

    <div class="m-container forprfile">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel-group">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                @include('frontend.dashboard.profile_main_nav')
                            </div><!-- panl-body -->
                        </div>

                    </div>
                </div><!-- sm4 -->
                <div class="col-sm-9">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="tab-heads">
                                    <h3>My list({{ $ads->count() }} Ads)</h3>

                                </div><!-- tab-heads -->

                            </div><!-- panel-heading -->
                            <div class="panel-body">
                                <div class="all-list-sh all-listing-total profil-listss">
                                    <ul>
                                        @foreach ($ads as $key => $ad)
                                            @php $img = ($ad->gallery->first())?$ad->gallery->first()->mobile_img:null; @endphp
                                            <li>
                                                <div class="eve-box">
                                                    <div class="al-img"> <span class="open-stat">{{ $ad->gallery->count() }}
                                                            Photos</span>
                                                        <a href="{{ url($ad->category->slug . '/' . $ad->slug) }}">
                                                            <img src="{{ asset('uploads/post/' . $img ?? '#') }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                    <div style="width: 100%;" class="mb-w1">
                                                        <h4>
                                                            <a href="{{ url($ad->category->slug . '/' . $ad->slug) }}">
                                                                {{ $ad->title }}
                                                            </a>
                                                            {{-- <img src="images/icon/svg/verified.png" alt=""></i> --}}
                                                        </h4>
                                                        @if ($ad->payment_type == 'amount' || $ad->payment_type == 'negotiable')
                                                            <h2>{{ formatPrice($ad->price) }}</h2>
                                                        @else
                                                            <h2>Contact For Price</h2>
                                                        @endif
                                                        <p> {!! $ad->description !!} </p>


                                                        <div class="links watchdesktLink">
                                                            <span class="news-location">
                                                                <img src="{{ asset('assets_frontend/img/icon/3.png') }}">
                                                                {{ $ad->city }} -
                                                                {{ $ad->created_at->diffForHumans() }}
                                                            </span>

                                                            <div class="dib">
                                                                <button class="wish addToList"
                                                                    data-id="{{ $ad->id }}">
                                                                    Remove From List
                                                                </button>

                                                                <a href="https://wa.me/{{ $ad->phone }}" class="what"
                                                                    target="_blank">Contact Seller</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="links watchMobileLink">
                                                        <span class="news-location">
                                                            <img src="{{ asset('assets_frontend/img/icon/3.png') }}">
                                                            {{ $ad->city }} - {{ $ad->created_at->diffForHumans() }}
                                                        </span>

                                                        <div class="dib">
                                                            <button class="wish addToList" data-id="{{ $ad->id }}">
                                                                Remove From List
                                                            </button>

                                                            <a href="https://wa.me/{{ $ad->phone }}" class="what"
                                                                target="_blank">Contact Seller</a>
                                                        </div>
                                                    </div>
                                            </li>
                                        @endforeach
                                        @if (count($ads) == 0)
                                            <li>
                                                <p style="text-align:center;margin:0;padding-top:30px;">No Ads Found</p>
                                            </li>
                                        @endif

                                    </ul>
                                </div>

                                {{ $ads->links() }}
                                    {{-- <nav aria-label="Page navigation example mt-5" class="example mt-5">
                                        <ul class="pagination text-center justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav> --}}


                            </div><!-- panl-body -->
                        </div>
                    </div><!-- sm8 -->
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
                        if (res == 0) {
                            $(_this).parents('.addt').removeClass('active');
                            $(_this).parents('li').remove();
                            var c = $('.all-listing-total').find('li').length;
                            $('.tads').text(c);
                            if (c == 0) {
                                $('.all-listing-total').find('ul').html(`
                                <li>
                                    <p style="text-align:center;margin:0;padding-top:30px;">No Ads Found</p>
                                </li>
                            `);
                            }
                        }
                    }
                })
            })
        </script>
    @endsection
