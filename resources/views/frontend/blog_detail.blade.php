@extends('layouts.frontend')
@section('title',(!empty($data->meta_title))?$data->meta_title:$data['title'].' | Salone Goo')
@section('seo')
    @include('frontend.seo', [ 'description'=>$data->meta_description??'', 'schema'=>$data['schema_code']??'', 'seo'=>$data['seo_meta']??[] ])
@endsection

@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_frontend/comments.css')}}">
<style>
    ul.category-list li a {color:#000;}
    .shareDiv .author span:before {content: "\f007";}
    .pglist-p-com-ti {display: flex; flex-direction: row; justify-content: space-between;}
    #cats {padding: 12px;}
    #cats ul {margin: 0;padding: 0;list-style: none;}
    #cats ul li {display: inline;}
</style>
@endsection

@section('content')

    <section class="blog_sech blog_detail_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="pglist-bg pglist-p-com">
                        <div class="pglist-p-com-ti">
                            <h2>{{ $data->title }}</h2>
                            <div id="cats">
                                <ul>
                                    {{-- <li><a href="#" class="badge badge-success">Cat One</a></li> --}}
                                    <li><a href="{{url('/blogs')}}?category={{$data->categories->value('id')}}" class="badge badge-success">{{$data->categories->value('title')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="detailbanner">
                            <img src="{{ url($data['image'] ?? '#') }}" alt="Product img">
                            <div class="shareDiv">
                                <div class="left-share">
                                    <div>
                                        <span>{{ date('M d, Y', strtotime($data->created_at)) }}</span>
                                    </div>
                                    {{-- <div class="views">
                                        <span>{{ $data->views_count }} views</span>
                                    </div>                                     --}}
                                    {{-- <div class="author">
                                        <span>{{$data['author']}}</span>
                                    </div>                                                                         --}}
                                </div>
                                <div class="rsocial">
                                    <strong>Share With:</strong>
                                    <ul>
                                        <li class="icon facebook">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                            </a>
                                        </li>
                                
                                        <li class="icon twitter">
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($data->title) }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                            </a>
                                        </li>
                                
                                        <li class="icon linkedin">
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="list-pg-inn-sp">
                                <div class="row pg-list-ser blog_textdetail">
                                    {!! $data->description !!}
                                </div>
                            </div>
                            <section>
                                <div class="comment-section">
                                    <div>
                                        <div>
                                            <h4>Comments ({{ $data->comments->count() }})</h4>
                                        </div>
                                        @foreach($data->comments as $comment)
                                        <div class="user-profile">
                                            <div class="comment-card">
                                                <div class="profile-img">
                                                    <img src="{{asset('avatar.jpg')}}" alt="{{ $comment->name }}">
                                                </div>
                                                <div class="comment-content">
                                                    <div class="comment-header">
                                                        <span class="username">{{ $comment->name }}</span>
                                                        <span class="date">{{ $comment->created_at->format('d M, Y') }}</span>
                                                    </div>
                                                    <p class="comment-text">{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div>
                                            <h4>Write a Comment</h4>
                                        </div>
                                        <div>
                                            <div id="comment-message"></div>
                                            <form class="comment-form" id="commentForm" action="{{route('blogComment', $data->id)}}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <input type="text" placeholder="Enter your full name" name="name" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" placeholder="Enter your email address"
                                                            required name="email">
                                                    </div>
                                                </div>
                                                <textarea placeholder="Your Comment" name="comment" required></textarea>
                                                <button type="submit">SUBMIT</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    @if(isset($related) && count($related) > 0)
                    <div class="all-list-sh all-listing-total relatedDv">
                        <h5 class="mb-3">Related Ads</h5>
                        <ul class="blog_area_h">
                            @foreach ($related as $data)
                                <li>
                                    <div class="blog_area">
                                        <img src="{{ url($data->image) }}" alt="">
                                        <div class="blog_text">
                                            <div class="bc_area">
                                                @foreach ($data->categories as $category)
                                                    <a href="{{ url('/blog/' . $data->slug) }}">{{ $category->name }}</a>
                                                @endforeach
                                            </div>
                                            <a href="{{ url('/blog/' . $data->slug) }}"
                                                class="btital">{{ $data->title }}</a>
                                            <span class="news-date"> {{ $data->date }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    @endif
                </div>
                @if(isset($posts))
                    <div class="col-md-4">
                        <div class="list-rhs-form pglist-bg pglist-p-com popularpast_area">
                            <div class="quote-pop">
                                <h3>Popular Posts</h3>
                                <div class="news-hom-ban-sli-inn">
                                    <ul class="blog-sli-h-2">
                                        @foreach ($posts as $data)
                                            <li>
                                                <a href="{{ url('/blog/' . $data->slug) }}">
                                                    <div class="news-hban-box">
                                                        <div class="im">
                                                            <img src="{{ url($data['image'] ?? '#') }}" alt="">
                                                        </div>
                                                        <div class="txt">
                                                            <h2>{{ $data->title }}</h2>
                                                            <span class="news-date"> {{ $data->date }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>                            
                        </div>
                        <div class="list-rhs-form pglist-bg pglist-p-com popularpast_area">
                            <div class="quote-pop">
                                <h3>Categories</h3>
                                <div class="pl-left myOfferForm_val">
                                    <ul class="category-list">
                                        <li><a href="{{route('blogsPage')}}">All Categories</a></li>
                                         @foreach($categories as $cat)
                                         <li><a href="{{route('blogsPage')}}?category={{$cat->id}}">{{$cat->title}}</a></li>
                                         @endforeach
                                      </ul>
                                </div>
                            </div>                            
                        </div>
                    </div>
                @endif
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

        $('.blog-sli-h-2').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
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
    </script>
    <script>
        $('#commentForm').on('submit', function(e) {
            var _action = $(this).attr('action');
            e.preventDefault();

            $.ajax({
                url: _action,
                type: "POST",
                data: $(this).serialize(),

                beforeSend: function() {
                    $('#comment-message').html('');
                },

                success: function(res) {

                    if (res.status) {

                        $('#comment-message').html(
                            '<div class="alert alert-success">' + res.message + '</div>'
                        );

                        $('#commentForm')[0].reset();
                    }

                },

                error: function(xhr) {

                    if (xhr.status === 422) {

                        let html = '<div class="alert alert-danger"><ul>';

                        $.each(xhr.responseJSON.errors, function(key, value) {
                            html += '<li>' + value[0] + '</li>';
                        });

                        html += '</ul></div>';

                        $('#comment-message').html(html);
                    }

                }
            });
        });
    </script>
@endpush
