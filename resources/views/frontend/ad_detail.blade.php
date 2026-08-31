@extends('layouts.frontend')
@section('title',(!empty($data->meta_title))?$data->meta_title:$data['title'].' | Batswana Goo')
@section('seo')
    @include('frontend.ad_seo', [ 
        'description' => $data->meta_description ?? '', 
        'schema' => $data['schema_code'] ?? '', 
        'seo' => $data['seo_meta'] ?? [],
        'advertise' => $data
    ])
@endsection
@section('customStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/css/intlTelInput.css">
    <style>
        .iti { width: 100%; }
        .iti__selected-flag { pointer-events: none; }
        .iti__arrow { display: none; }
    </style>
    <style type="text/css">
    .success_offer_send {
            font-size: 12px;
            line-height: 15px;
            color: green;
            text-align: center;
            padding-top: 15px;
            font-weight: 500;
            display: none;
        }

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
    	.btn.btn-primary {
    		border: none;
    	}
    		.list-pg-rt .card-header {
    			background: #20334c;
    			padding: 0;
    		}
    		.list-pg-rt .card-header a {
    			color: #fff;
				display: block;
				padding: 0.75rem 1.25rem;
			    		}
			    		.accordion-c {
				padding: 20px;
				background: #f8f9fa;
			}
    		.accordion-c .card {
    			background: #fff;
    			margin-top: 2px;
    			border: none;
    		}
    		.accordion-c label {
    			margin-bottom: 2px;
			  font-size: 13px;
			  font-weight: 500;
    		}
    		.accordion-c input {
    			border: 1px solid #e1e4e6;
			  font-size: 14px;
			  font-weight: 500;
			  border-radius: 4px;
			  width: 100%;
			  padding-left: 16px;
			  height: 40px;
    		}
    		.accordion-c textarea {
    			height: 45px;
				  position: relative;
				  padding: 12px 14px;
				    padding-left: 14px;
				  padding-left: 18px;
				  box-sizing: border-box;
				  box-shadow: none;
				  border: 1px solid #e8e8e8;
				  text-indent: 0;
				  line-height: 21px;
				  -webkit-transition: border-color .4s, color .4s;
				  transition: border-color .4s, color .4s;
				  -webkit-appearance: none;
				  width: 100%;
				  font-size: 14px;
				  background: #fff;
    		}
    		.accordion-c button {
				color: #fff;
				background-color: #1eaf38;
				border-color: #1eaf38;
				font-size: 14px;
				width: 100%;
    		}
    		.accordion-c button:hover {
    			background-color: #000;
    			color: #fff;
    			border: none;
    		}
    		.success_offer_send {
				background: #eff7ef;
			  color: #044004;
			  font-size: 12px;
			  padding: 9px 17px;
			  margin-top: 10px;
			  border-radius: 3px;
			  border: 1px solid #26b526;
			}
			.chats-offers {

			}
			.chats-offers textarea::placeholder {
				opacity: 0.5;
			}
			.accordion-c label {
				display: block;
			}
			.chats-offers ul {
				display: flex;
				  flex-wrap: nowrap;
				  padding-bottom: 12px;
				  margin: 4px 0;
				  overflow-x: scroll;
			}
			.chats-offers ul li {
				background-color: transparent;
				  border: 1px solid #00b53f;
				  border-radius: 4px;
				  color: #00b53f;
				  font-size: 14px;
				  margin-right: 10px;

				  transition: .3s ease;
				  white-space: nowrap;
			}
			.chats-offers h4 {
				font-size: 16px;
			}
			.chats-offers ul li a {
				  display: block;
				  font-size: 14px;
				  border-radius: 4px;
				  padding: 7px 10px;
				  color: #1eaf38;
				  line-height: 16px;
			}
			.card-link {
				position: relative;
			}
			.card-link::after {
			 content: "\f107";
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  float: none;
  position: absolute;
  right: 18px;
  color: #fff;
  font-size: 17px;
  top: 13px;
			}
			.card-link.collapsed::after {
  content: "\f106";
}
    	</style>
    @if (!auth()->check())
        <style>
            .rsocial:before {
                content: none;
            }
        </style>
    @endif
@endsection
@section('content')

    <section class="all-list-bre brd-1">
        <div class="container sec-all-list-bre">
            <div class="row">
                <!-- <h2>Electronics</h2> -->
                <ul>
                    <li> <a href="{{ url('/') }}">Back to Search</a> </li>
                    <li> <a href="{{ url('categories?country=' . fetchCountryId($data->country)) }}">{{ $data->country }}</a> </li>
                    <li> <a
                            href="{{ url('categories?country=' . fetchCountryId($data->country) . '&state=' . fetchStateId($data->state)) }}">{{ $data->state }}</a>
                    </li>
                    <li> <a
                            href="{{ url('categories?country=' . fetchCountryId($data->country) . '&state=' . fetchStateId($data->state) . '&city=' . fetchCityId($data->city)) }}">{{ $data->city }}</a>
                    </li>
                    @foreach ($data->category->breadcrumbs as $cate)
                        <li><a href="{{ url(generateUrl($cate->id)) }}">{{ $cate->name }}</a></li>
                    @endforeach
                    <li><span>{{ $data->title }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>


    <section class=" list-pg-bg">
        <div class="container">
            <div class="row">
                <div class="com-padd">
                    <div id="ld-abo" class="list-pg-lt list-page-com-p">
                        <!--                        -->
                        <!--LISTING DETAILS: LEFT PART 1-->
                        <div class="pglist-bg pglist-p-com">
                            <div class="pglist-p-com-ti">
                                <h2>{{ $data->title }}</h2>
                                @if ($data->payment_type == 'amount')
                                    <h3> {{ formatPrice($data->price) }} </h3>
                                @elseif($data->payment_type == 'negotiable' || $data->payment_type == 'contact')
                                    <h3> {{ formatPrice($data->price) }} <em>or</em> <small><a href="javascrip:void()"
                                                class="makeOffer">Make an
                                                Offer</a></small></h3>
                                @else
                                    {{-- <h3><small><a href="javascrip:void()" class="makeOffer">Make an Offer</a></small></h3> --}}
                                    <h3><small><a href="javascrip:void()">{{$data->payment_type}}</a></small></h3>
                                @endif
                            </div>
                            <div class="detailbanner">
                                <div class="banner-slider">
                                    <div class="product-img-slide">
                                        <div class="slider-for">
                                            @foreach ($data->gallery as $img)
                                                <div><img src="{{ asset('uploads/post/' . $img->image ?? '#') }}"
                                                        alt="{{ $data->name }}"></div>
                                            @endforeach
                                        </div>
                                        <div class="slider-nav">
                                            @foreach ($data->gallery as $img)
                                                <div class="thumb-slide"><img
                                                        src="{{ asset('uploads/post/' . $img->image ?? '#') }}"
                                                        alt="{{ $data->name }}"></div>
                                            @endforeach
                                        </div>

                                        <div class="shareDiv">
                                            <div class="left-share">
                                                <div>
                                                    <span>{{ $data->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div>
                                                    <span class="views">{{ $data->views }} views</span>
                                                </div>
                                            </div>

                                            <div class="right-share">
                                                @if (auth()->check())
                                                    <div class="addt @if ($data->wishlist != null) active @endif ">
                                                        <span><a href="javascript:void(0);" class="addToList"
                                                                data-id="{{ $data->id }}">
                                                                @if ($data->wishlist != null)
                                                                    Saved to List
                                                                @else
                                                                    Add to my list
                                                                @endif
                                                            </a></span>
                                                    </div>
                                                @endif
                                                <div class="rsocial">
                                                    <strong>Share With:</strong>
                                                    <ul>
                                                        <li class="icon facebook">
                                                            <a
                                                                href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}">
                                                            </a>
                                                        </li>
                                                        <li class="icon linkedin">
                                                            <a
                                                                href="//www.linkedin.com/shareArticle?mini=true&url={{ request()->url() }}">
                                                            </a>
                                                        </li>
                                                        <li class="icon twitter">
                                                            <a
                                                                href="//twitter.com/intent/tweet?text={{ str_replace(' ', '+', $data['title']) }}&amp;url={{ request()->url() }}">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- product-img-slide -->
                                </div>

                            </div>
                        </div>
                        <!--                            -->
                        <!--END LISTING DETAILS: LEFT PART 1-->
                        <!--LISTING DETAILS: LEFT PART 2-->
                        <div id="ld-ser" class="pglist-bg pglist-p-com general">
                            <div class="pglist-p-com-ti">
                                <h3>General Details</h3>
                            </div>
                            <div class="list-pg-inn-sp">
                                <div class="row pg-list-ser">
                                    <p>
                                        {!! nl2br($data->description ?? null) !!}
                                    </p>
                                    <ul>
                                        {{-- <li>
                                            <b> Country </b>: <span style="color:#1eaf38;">{{ $data->country }}</span>
                                        </li> --}}
                                        <li>
                                            <b> State </b>: <span style="color:#1eaf38;">{{ $data->state }}</span>
                                        </li>
                                        <li>
                                            <b> City </b>: <span style="color:#1eaf38;">{{ $data->city }}</span>
                                        </li>
                                        @if (isset($data->fields))                                        
                                            @foreach ($data->fields as $key => $val)
                                                @if(!empty($val['value']))
                                                <li>
                                                    @if (isset($val->field->field->type) && $val->field->field->type == 'checkbox')
                                                        <b> {{ $val['name'] }} </b>:
                                                        {{ $val['value'] == 1 ? 'Yes' : 'No' }}                                                    
                                                    @else
                                                    <b>{{ $val['name'] }}</b>:
                                                    {!! filter_var($val['value'], FILTER_VALIDATE_URL)
                                                        ? '<a href="'.$val['value'].'" style="white-space: normal;display: block;word-break: break-all;" target="_blank">'.$val['value'].'</a>'
                                                        : (is_array($a = json_decode($val['value'], true)) ? implode(', ', $a) : $val['value'])
                                                    !!}
                                                    @endif
                                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="list-pg-rt">
                        <!--LISTING DETAILS: LEFT PART 9-->
                        <div class="list-rhs-form pglist-bg pglist-p-com">
                            <div class="quote-pop">
                                <h3>{{ $data->user->name ?? $data->user->first_name }}
                                    <small>Selling for <b>{{ $data->user->created_at->diffForHumans() }}</b> <em>|</em>
                                        Active Ads <b> {{ $data->user->activeAds->count() }}</b></small>
                                </h3>
                                <div class="pl-left">
                                    <strong>Seller Stats</strong>
                                    <ul>
                                        <li class="stars"><b>{{ $data->user->ads->count() }}</b> Total Ads</li>
                                        <li class="views"><b>{{ $data->user->ads->sum('views') }}</b> Total Views</li>
                                    </ul>
                                    @auth
                                    @if(isset($data->user->show_address_on_adds) && $data->user->show_address_on_adds==1)
                                    <strong>Address</strong>
                                    <p>
                                        {{ ($data->user->company_address)??'' }}
                                    </p>
                                    @endif
                                    @endauth
                                    <div class="text-right vp">
                                        @if($data->user->slug == null)
                                        <a href="{{ url('profile/' . $data->user->id) }}">View Profile</a>
                                        @else
                                        <a href="{{ route('shop', $data->user->slug) }}">View Profile</a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($data->payment_type == 'negotiable' || $data->payment_type == 'contact')
                            <div class="list-rhs-form pglist-bg pglist-p-com makeOfferBox">
                                <div class="quote-pop grens">
                                    <h3 style="background:#20334c;">Make an offer</h3>
                                    <!-- <small>Selling for 3+ yearsActive Ads 1</small></h3> -->

                                    <div class="pl-left myOfferForm_val">
                                        <p>Interested in this item? Send the seller an offer now.</p>
                                        @if ($data->payment_type == 'amount' || $data->payment_type == 'negotiable')
                                            <h5>Selling for: {{ formatPrice($data->price) }}</h5>
                                        @endif

                                        <div class="form-group">
                                            <label>Your offer</label>
                                            <input type="number" name="myOffer" placeholder="Enter Your Name" required
                                                form="myOfferForm">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone No</label>
                                            <input id="offer-phone" type="tel" name="phone" placeholder="71 123 456" required
                                                form="myOfferForm">
                                        </div>
                                    </div>
                                    <form id="myOfferForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="adv_id" value="{{ $data->id }}" />
                                        <input type="hidden" name="type" value="offer" />
                                        <button type="submit" name="enquiry_submit" class="btn btn-primary"
                                            @if (auth()->check() && auth()->user()->id == $data->user_id) disabled @endif
                                            style="background:#20334c;">Make an Offer</button>
                                        <div class="success_offer_send">Your offer successfully send, seller will contact
                                            you soon on your giving phone no.</div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if ($data->user->chats == 0)
                        <div class="list-rhs-form pglist-bg pglist-p-com">
                            <div id="accordion" class="accordion-c">
                                    {{-- "Contact With" card disabled - the phone reveal moved into "Chat With" below.
                                    <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                        Contact With {{ $data->user->first_name??$data->user->name }} {{ $data->user->last_name }}
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <form id="MsgForm" class="myOfferForm_val">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label>Your Message</label>
                                                    <textarea rows="6" required name="msg" placeholder="Your Message"
                                                        style="height: 100px;line-height: 15px;font-size: 12px;">Hi, I’m interested in {{ $data->title }}. Please contact me. Thanks!</textarea>
                                                </div>
                                                @if (!auth()->check())
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" required
                                                            placeholder="Enter Your Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <input type="text" name="email" required
                                                            placeholder="Enter Email Address">
                                                    </div>
                                                @else
                                                    <input type="hidden" name="name"
                                                        value="{{ auth()->user()->first_name }}">
                                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                                @endif
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="number" name="phone" placeholder="Enter Phone No">
                                                </div>
                                                <button type="submit" id="detail_enquiry_submit" name="enquiry_submit"
                                                    class="btn btn-primary" @if (auth()->check() && auth()->user()->id == $data->user_id) disabled @endif>Send
                                                    Message</button>

                                                <input type="hidden" name="adv_id" value="{{ $data->id }}" />
                                                <input type="hidden" name="type" value="msg" />

                                                <div class="success_offer_send">Your msg successfully send to seller, He/She will
                                                    contact you soon on your giving phone no.</div>
                                            </form>
                                        </div><!-- card-body -->
                                    </div>
                                    </div>
                                    --}}
                                    @if(Auth::check() && Auth::user()->id!=$data->user->id)
                                    <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                        Chat With {{ $data->user->first_name??$data->user->name }} {{ $data->user->last_name }}
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="seller-phone">
                                                <div class="phont">
                                                    <span class="icon-web-phone icon-web-phone-green"></span>
                                                    <span class="mask-phone">{{ substr($data->phone, 0, 3) }}*******</span>
                                                    @if (auth()->check())
                                                        <a id="showphone" href="tel:{{ $data->phone }}"
                                                            style="display: none;">{{ $data->phone }}</a>
                                                        <span class="display-phone">Show Number</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="chats-offers">
                                                <label>Your Message</label>
                                            <form action="{{route('startChat')}}" method="POST">
                                                <ul>
                                                    <li><a href="javascript:void(0);" class="quick-msg" data-value="My offer is {{ formatPrice($data->price??0) }}">Make an offer</a></li>
                                                    <li><a href="javascript:void(0);" class="quick-msg" data-value="Is this available?">Is this available</a></li>
                                                    <li><a href="javascript:void(0);" class="quick-msg" data-value="Last Price?">Last Price</a></li>
                                                </ul>
                                                {{csrf_field()}}
                                                <textarea class="form-control" id="msg-input"  placeholder="Type Your Message" name="msg" required></textarea>
                                                <input type="hidden" name="ad_id" value="{{$data['id']}}">
                                                <button class="btn btn-primary mt-3" type="submit">Start Chat</button>
                                            </form>
                                        </div>
                                        </div><!-- card-body -->
                                    </div>
                                    </div>
                                    @else
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="collapsed card-link" href="{{route('front.login')}}">
                                            Login to chat
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif


                        <div class="list-rhs-form pglist-bg pglist-p-com">
                            <div class="quote-pop">
                                <h3>Safety tips</h3>
                                <div class="pl-left myOfferForm_val">
                                    <div>
                                        <ul>
                                            <li>Don't pay in advance, including for delivery</li>
                                            <li>Meet the seller at a safe public place</li>
                                            <li>Inspect the item and ensure it's exactly what you want</li>
                                            <li>On delivery, check that the item delivered is what was inspected</li>
                                            <li>Only pay when you're satisfied</li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                        {{-- {{ dd($data, auth()->user()->id == $data->user_id) }} --}}
                        @if (auth()->check())
                            <div class="list-rhs-form pglist-bg pglist-p-com">
                                <div class="quote-pop">
                                    <div class="pl-left">

                                        @if (auth()->check() && $data->user_id != auth()->user()->id)
                                            @if ($data->user->feedback == 0)
                                                <a href="{{ route('feedback', $data->user->id) }}"
                                                    class="btn btn-success mb-2">Place
                                                    Feedback</a>
                                            @endif
                                            <a id="mark_unavailable" data-id="{{ $data->id }}"
                                                href="javascript:void(0)" class="btn btn-warning text-dark mb-2">Mark
                                                Unavailable</a>

                                            {{-- <a id="mark_report" data-id="{{ $data->id }}" href="javascript:void(0)"
                                                class="btn btn-danger mb-2">Report Abuse</a> --}}

                                            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#ReportAbuse">
                                                Report Abuse
                                            </button>

                                            <a href="{{ url('postAdd') }}?like={{($data->id)??''}}" class="btn btn-info">Post Ad Like this</a>
                                        @else
                                            <a href="{{ route('feedback', $data->user->id) }}"
                                                class="btn btn-success mb-2">Send Feedback Link</a>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        @endif







                        <!--END LISTING DETAILS: LEFT PART 9-->
                        <!--LISTING DETAILS: LEFT PART 7-->

                        <!--END LISTING DETAILS: LEFT PART 7-->
                        <!--LISTING DETAILS: COMPANY BADGE-->

                        <!--END LISTING DETAILS: COMPANY BADGE-->
                        <!--LISTING DETAILS: LEFT PART 8-->

                        <!--END LISTING DETAILS: LEFT PART 8-->
                        <!--LISTING DETAILS: LEFT PART 9-->

                        <!--END LISTING DETAILS: LEFT PART 9-->
                        <!--LISTING DETAILS: LEFT PART 7-->

                        <!--END LISTING DETAILS: LEFT PART 7-->
                        <!--LISTING DETAILS: LEFT PART 10-->

                        <!--END LISTING DETAILS: LEFT PART 10-->
                        <!--ADS-->

                        <!--ADS-->
                    </div>
                </div>

                @if (count($related) > 0)
                    <div class="all-list-sh all-listing-total relatedDv">
                        <h5 class="pl-4 mb-3">Related Ads</h5>
                        <ul>
                            @foreach ($related as $rel)
                                @php $img = ($rel->gallery->first() != null)?$rel->gallery->first()->mobile_img:null; @endphp
                                <li>
                                    <div class="eve-box">
                                        <!---LISTING IMAGE--->
                                        <div class="al-img"> <span class="open-stat">{{ $rel->gallery->count() }}
                                                Photos</span>
                                            <a href="{{ url(generateUrl($rel->category_id, 'category', $rel->slug)) }}">
                                                <img src="{{ asset('uploads/post/' . $img) }}"
                                                    alt="{{ $rel->title }}">
                                            </a>
                                        </div>
                                        <!---END LISTING IMAGE--->
                                        <!---LISTING NAME--->
                                        <div>
                                            <h4>
                                                <a
                                                    href="{{ url(generateUrl($rel->category_id, 'category', $rel->slug)) }}">{{ $rel->title }}</a>
                                            </h4>

                                            <p>{!! $rel->description !!}</p>
                                            <span class="pho">7904462944</span>
                                            <span class="mail">thedirectoryfinder@gmail.com</span>
                                            <div class="links">
                                                <span class="news-location" style="text-transform: capitalize">
                                                    <img src="{{ asset('assets_frontend/img/icon/3.png') }}">
                                                    {{ $rel->city }}, {{ $rel->country }} -
                                                    {{ $rel->created_at->diffForHumans() }}
                                                </span>
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
                @endif
            </div>
        </div>
    </section>

    <section class="suggested">
        <div class="container">
            @if (count($suggested) > 0)
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Suggested</h3>
                        <ul>
                            @foreach ($suggested as $ad)
                                <li><a href="{{ url(generateUrl($ad->category_id, 'category', $ad->slug)) }}">{{ $ad->title }}</a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                <hr>
            @endif
            @if (count($populars) > 0)
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Popular</h3>
                        <ul>
                            @foreach ($populars as $cate)
                                <li><a href="{{ url(generateUrl($cate->id, 'category')) }}">{{ $cate->name }}</a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            @endif
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

    <!-- Modal -->
    <div class="modal fade" id="ReportAbuse" tabindex="-1" aria-labelledby="ReportAbuseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReportAbuseLabel">Report For {{ $data->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ReportAbuse') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="adv_id" value="{{ $data->id }}" />
                        <div class="form-group">
                            <select class="form-control" name="reason_type" required>
                                <option value="" selected disabled style="display:none">Report Reason</option>
                                <option value="spam">This ad is spam</option>
                                <option value="price_wrong">The price is wrong</option>
                                <option value="wrong_category">Wrong category</option>
                                <option value="prepayment">Seller asked for prepayment</option>
                                <option value="sold">It is sold</option>
                                <option value="user_unreachable">User is unreachable</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_desc" placeholder="Please describe your issue" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('customScripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        // "Make an offer" phone field, locked to Botswana - same as the dashboard profile phone field.
        $(document).ready(function () {
            const offerPhoneInput = document.getElementById('offer-phone');
            if (offerPhoneInput) {
                window.intlTelInput(offerPhoneInput, {
                    initialCountry: 'bw',
                    onlyCountries: ['bw'],
                    separateDialCode: true,
                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js',
                });

                $(offerPhoneInput).on('input', function () {
                    const validChars = /^[0-9]*$/;
                    if (!validChars.test(this.value)) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    }
                });
            }
        });

        $(".view-btn").click(function() {
            $(".location-list").toggleClass("view-all-open");
        });


        $(".view-btn-pay").click(function() {
            $(".payment-list").toggleClass("view-all-open-pay");
        });


        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            vertical: true,
            asNavFor: '.slider-for',
            dots: false,
            focusOnSelect: true,
            verticalSwiping: true
        });


        $('.display-phone').on('click', function() {
            var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
            if (loggedIn) {
                $('#showphone').toggleClass('activePhone');
                $('.mask-phone').hide();
                $('.display-phone').hide();
            } else {
                alert('Logged In First!');
            }
        });

        $(".pmenu-spri ul li").mouseenter(function() {
            //console.log($(this).attr('data-name'));
            $('.pmenu-cat ul').removeClass('activeul').addClass('hideul');


            name = $(this).attr('data-name');
            $('#' + name).removeClass('hideul').addClass('activeul');
        }).mouseleave(function() {
            //alert('hide');
        });

        $(document).ready(function() {

            $(document).on('click', '.makeOffer', function() {
                $('[name="myOffer"]').css('border', 'solid 1px #1eaf38');
                $('html, body').animate({
                    scrollTop: $(".makeOfferBox").offset().top - 100
                }, 500);
                setTimeout(() => {
                    $('[name="myOffer"]').css('border', 'solid 1px #e1e4e6');
                }, 3000);
            });
            $(document).on('submit', '#myOfferForm, #MsgForm', function(e) {
                e.preventDefault();

                var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
                if (loggedIn) {
                    var _this = $(this);
                    var btn = $(this).find('[type="submit"]').html();
                    $(this).find('[type="submit"]').html(
                        '<i class="fa fa-refresh fa-spin"></i> Please wait...')
                    $(this).find('[type="submit"]').attr('disabled', 'disabled');
                    var data = $(this).serialize();
                    $.ajax({
                        url: "{{ url('myOffer') }}",
                        type: 'POST',
                        data: data,
                        success: function() {
                            $(_this).find('.success_offer_send').fadeIn(300).delay(7000)
                                .fadeOut(
                                    300);
                            $(_this).find('[type="submit"]').removeAttr('disabled');
                            $(_this).find('[type="submit"]').html(btn);
                            $('.myOfferForm_val').find(
                                '[type="number"], [type="text"], [type="email"]').each(
                                function(
                                    k, v) {
                                    $(v).val('');
                                });
                        },
                        error: function() {
                            $(_this).find('[type="submit"]').removeAttr('disabled');
                            $(_this).find('[type="submit"]').html(btn);
                        }
                    });
                } else {
                    alert('Logged In First!');
                }
            });
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
            $(document).on('click', '#mark_unavailable', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1eae38',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, unavailable!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).attr('data-id');

                        $.ajax({
                            url: "{{ url('make-unavailable') }}",
                            type: 'POST',
                            data: {
                                adv_id: id,
                                report: 0,
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function() {
                                setTimeout(() => {
                                    $('.alert-success').fadeOut(300);
                                }, 3000);
                                location.reload();
                            },

                        })
                    }
                })
            });
            $(document).on('click', '#mark_report', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1eae38',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, unavailable!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).attr('data-id');

                        $.ajax({
                            url: "{{ url('make-report') }}",
                            type: 'POST',
                            data: {
                                adv_id: id,
                                report: 1,
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function() {
                                setTimeout(() => {
                                    $('.alert-success').fadeOut(300);
                                }, 3000);
                                location.reload();
                            },

                        })
                    }
                })
            });

        });

        $(".quick-msg").click(function(){
            $("#msg-input").text($(this).data('value'));
        });
    </script>
@endsection
