@extends('layouts.frontend')
@section('title',$seo['meta_title']??'Blogs | Salone Goo')
@section('seo')
    @include('frontend.seo', [ 'description'=>$seo['meta_description']??'', 'schema'=>$seo['schema_code']??'', 'seo'=>$seo??[] ])
@endsection
@push('push_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <style>
        .slick-arrow:before {
            content: 'chevron_left';
            font-size: 27px;
            font-family: "Material Icons";
            color: #9d9a98;
            top: 1px !important;
            left: 2px !important;
        }
        </style>

@endpush
@section('content')

    <section class="all-list-bre brd-1">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><span>Blog</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="blog_sech">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="n-sliders">
                        @isset($seo['page_title']) <h1 style="margin-left: 10px; margin-bottom: 15px;">{{$seo['page_title']}}</h1> @endisset
                        @isset($seo['page_description']) <p>{{$seo['page_description']}}</p> @endisset
                        <div class="">
                            <ul class="nblogss">
                                @foreach ($posts as $post)
                                    @if ($post->is_featured == 1)
                                        <li>
                                            <a href="{{route('blogDetail', $post->slug)}}">
                                                <div class="news-hban-box">
                                                    <div class="im">
                                                        <img src="{{ url($post->image) }}" alt="">
                                                    </div>
                                                    <div class="txt">
                                                        <h2>{{ $post->title }}</h2>
                                                        {{-- <span class="news-date">{{ $post->date }}</span> --}}
                                                    </div>
                                                </div>
                                            </a>
                                        </li>


                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="bs_leftarea">
                        <ul class="blog_area_h">
                            @foreach ($posts as $post)
                                <li>
                                    <div class="blog_area">
                                        <span class="news-date">{{ $post->date }}</span>
                                        <a href="{{route('blogDetail', $post->slug)}}"><img src="{{ url($post->image) }}"
                                                alt=""></a>
                                        <div class="blog_text">
                                            <div class="bc_area">
                                                @foreach ($post->categories as $category)
                                                    <a href="{{route('blogDetail', $post->slug)}}">{{ $category->title }}</a>
                                                @endforeach
                                            </div>
                                            <a href="{{route('blogDetail', $post->slug)}}" class="btital">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="pop-ups pop-quo">
            <!-- The Modal -->
            <div class="modal fade" id="quote">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="log-bor">&nbsp;</div>
                        <span class="udb-inst">Send enquiry</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <!-- Modal Header -->
                        <div class="quote-pop">
                            <h3>Johann van Vuuren</h3>
                            <h4>Selling for 3+ yearsActive Ads 1</h4>
                            <div id="pop_enq_success" class="log" style="display: none;">
                                <p>Your
                                    Enquiry Is Submitted Successfully</p>
                            </div>
                            <div id="pop_enq_same" class="log" style="display: none;">
                                <p>You cannot make
                                    enquiry on your own listing</p>
                            </div>
                            <div id="pop_enq_fail" class="log" style="display: none;">
                                <p>Something
                                    Went Wrong!!!</p>
                            </div>
                            <form method="post" name="popup_enquiry_form" id="popup_enquiry_form">

                                <div class="form-group">
                                    <input type="text" name="enquiry_name" value="" required="required"
                                        class="form-control" placeholder="Enter name*">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Enter email*"
                                        required="required" value="" name="enquiry_email"
                                        pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                        title="Invalid email address">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="" name="enquiry_mobile"
                                        placeholder="Enter mobile number *" pattern="[7-9]{1}[0-9]{9}"
                                        title="Phone number starting with 7-9 and remaing 9 digit with 0-9" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="enquiry_message" placeholder="Enter your query or message"></textarea>
                                </div>
                                <input type="hidden" id="source">
                                <button disabled="disabled" type="submit" id="popup_enquiry_submit"
                                    name="popup_enquiry_submit" class="btn btn-primary"> Log In To Submit </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- The Modal -->
            <div class="modal fade" id="claim">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="log-bor">&nbsp;</div>
                        <span class="udb-inst">Claim now</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <!-- Modal Header -->
                        <div class="quote-pop">
                            <h4>Claim this business</h4>
                            <div id="pop_claim_success" class="log" style="display: none;">
                                <p>Your
                                    Claim Request Submitted Successfully</p>
                            </div>
                            <div id="pop_claim_same" class="log" style="display: none;">
                                <p>You cannot make
                                    enquiry on your own listing</p>
                            </div>
                            <div id="pop_claim_fail" class="log" style="display: none;">
                                <p>Something
                                    Went Wrong!!!</p>
                            </div>
                            <form method="post" name="popup_claim_form" id="popup_claim_form">
                                <fieldset disabled="disabled">
                                    <input type="hidden" class="form-control" name="listing_id" value="381"
                                        placeholder="" required>
                                    <input type="hidden" class="form-control" name="listing_user_id" value="37"
                                        placeholder="" required>
                                    <input type="hidden" class="form-control" name="enquiry_sender_id" value=""
                                        placeholder="" required>
                                    <input type="hidden" class="form-control" name="enquiry_source" value="Website"
                                        placeholder="" required>
                                    <div class="form-group">
                                        <input type="text" name="enquiry_name" value="" required="required"
                                            class="form-control" placeholder="Enter name*">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control"
                                            placeholder="Enter this business email id*" required="required"
                                            value="" name="enquiry_email"
                                            pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                                            title="Invalid email address">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="" name="enquiry_mobile"
                                            placeholder="Enter mobile number *" pattern="[7-9]{1}[0-9]{9}"
                                            title="Phone number starting with 7-9 and remaining 9 digit with 0-9" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="enquiry_image"
                                            placeholder="Identification Proof *" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="enquiry_message"
                                            placeholder="Enter your query and why claim this business"></textarea>
                                    </div>
                                    <input type="hidden" id="source">
                                    <button type="submit" disabled="disabled" id="popup_claim_submit"
                                        name="popup_claim_submit" class="btn btn-primary">Log In To Submit
                                    </button>
                                </fieldset>
                            </form>
                            <div class="form-notes">
                                <p>We send you the verification email to you provider the email id. Once
                                    you done the verification process then you can manage this business.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('push_script')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'></script>
    <script>
        $('.blog-sli-h').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false
                }
            }]

        });

        if($('.nblogss li').length > 2) {
        $('.nblogss').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 2500,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false
                }
            }]

        });
    }
    </script>
@endpush
