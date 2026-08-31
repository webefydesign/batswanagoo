@extends('layouts.frontend')
@section('title', 'Feedback' . ' | Salone Goo')
@section('customStyles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <style>
        .success_offer_send {
            font-size: 12px;
            line-height: 15px;
            color: green;
            text-align: center;
            padding-top: 15px;
            font-weight: 500;
            display: none;
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

    {{-- Session Message --}}
        <div class="status_msg">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
        </div>
    {{-- Session Message --}}

    {{-- Breadcrum --}}
        <section class="all-list-bre brd-1">
            <div class="container sec-all-list-bre">
                <div class="row">
                    <ul>
                        <li><a href="javascript:void(0);">{{ $seller->name }}</a></li>
                        <li><span>Feedback</span></li>
                    </ul>
                </div>
            </div>
        </section>
    {{-- Breadcrum --}}

    <section class="list-pg-bg feedback_sec">
        <div class="container">
            <div class="row">
                <div class="com-padd">
                    <div id="ld-abo" class="list-pg-lt list-page-com-p">
                        {{-- <!--LISTING DETAILS: LEFT PART 1--> --}}
                        <div class="pglist-bg pglist-p-com">
                            <div class="pglist-p-com-ti">
                                <h2>Feedback about <a href="#">{{ $seller->name }}</a></h2>
                                <div class="feedback_tabs">
                                    <div class="feed-inner">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                                                    <span class="mess_icon"></span>
                                                    {{ $data->where('rating', 1)->count() }}
                                                    Positive
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                                    <span class="mess_icon"></span>
                                                    {{ $data->where('rating', 2)->count() }}
                                                    Neutral
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                                                    <span class="mess_icon"></span>
                                                    {{ $data->where('rating', 3)->count() }}
                                                    Negative
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="fb-right">
                                            @if (feedbackPermission($seller))
                                                <div class="nav-item">
                                                    <button type="button" class="btn btn-primary pfd-btn"
                                                        style="background-color: #1eaf38 ; border-color: #1eaf38"
                                                        data-toggle="modal" data-target="#feedbackModal">
                                                        Place Your Feedback
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            @foreach ($data as $message)
                                                <div class="single_feedback">
                                                    @if ($message->parent_id == null && $message->rating != 2 && $message->rating != 3)
                                                        <div class="customer_feedback">
                                                            <div class="cus_profile">
                                                                <h6>
                                                                    <img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}" alt="">
                                                                    {{ $message->user->name }}
                                                                </h6>
                                                                <span class="mess_icon_p"></span>
                                                            </div>
                                                            <p class="feedback_c">{{ $message->message }}</p>
                                                            <div class="dtr_text">
                                                                <p>{{ date('dS M, Y', strtotime($message->created_at)) }}
                                                                    @if (auth()->check())
                                                                        <span class="replyBtn">Reply</span>
                                                                    @endif
                                                                </p>
                                                                <div class="reply" style="display: none">
                                                                    <form method="post"
                                                                        action="{{ route('feedbackProcess') }}">
                                                                        {{ csrf_field() }}
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="message" class="form-control" required>
                                                                            <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : 0 }}">
                                                                            <input type="hidden" name="seller_id" value="{{ $message->seller_id }}">
                                                                            <input type="hidden" name="parent_id" value="{{ $message->id }}">
                                                                            <input type="hidden" name="rating" value="{{ $message->rating }}">
                                                                            <div class="input-group-append">
                                                                                <button type="submit">
                                                                                    <span class="material-icons" style="font-size: 25px;display: flex;align-items: center;justify-content: center;">send</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $check)
                                                        @if ($check->parent_id == $message->id && $message->rating != 2 && $message->rating != 3)
                                                            <div class="user_feedback">
                                                                <div class="cus_profile">
                                                                    <h6><img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}"
                                                                            alt="">{{ $check->user->name }}
                                                                    </h6>
                                                                </div>
                                                                <p class="feedback_c">{{ $check->message }}</p>
                                                            </div>
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            @foreach ($data as $message)
                                                <div class="single_feedback">
                                                    @if ($message->parent_id == null && $message->rating != 1 && $message->rating != 3)
                                                        <div class="customer_feedback">
                                                            <div class="cus_profile">
                                                                <h6><img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}" alt="">
                                                                    {{ $message->user->name }}
                                                                </h6>
                                                                @if ($message->rating == 1)
                                                                    <span class="mess_icon_p">
                                                                @elseif ($message->rating == 2)
                                                                    <span class="mess_icon_n">
                                                                @else
                                                                    <span class="mess_icon_ng">
                                                                @endif
                                                            </div>
                                                            <p class="feedback_c">{{ $message->message }}</p>
                                                            <div class="dtr_text">
                                                                <p>
                                                                    {{ date('dS M, Y', strtotime($message->created_at)) }}
                                                                    @if (auth()->check())
                                                                        <span class="replyBtn">Reply</span>
                                                                    @endif
                                                                </p>
                                                                <div class="reply" style="display: none">
                                                                    <form method="post" action="{{ route('feedbackProcess') }}">
                                                                        {{ csrf_field() }}
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="message" class="form-control" required>
                                                                            <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : 0 }}">
                                                                            <input type="hidden" name="seller_id" value="{{ $message->seller_id }}">
                                                                            <input type="hidden" name="parent_id" value="{{ $message->id }}">
                                                                            <input type="hidden" name="rating" value="{{ $message->rating }}">
                                                                            <div class="input-group-append">
                                                                                <button type="submit">
                                                                                    <span class="material-icons" style="font-size: 25px;display: flex;align-items: center;justify-content: center;">send</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $check)
                                                        @if ($check->parent_id == $message->id && $message->rating != 1 && $message->rating != 3)
                                                            <div class="user_feedback">
                                                                <div class="cus_profile">
                                                                    <h6>
                                                                        <img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}" alt="">
                                                                        {{ $check->user->name }}
                                                                    </h6>
                                                                </div>
                                                                <p class="feedback_c">{{ $check->message }}</p>
                                                            </div>
                                                            <br>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                            @foreach ($data as $message)
                                                <div class="single_feedback">
                                                    @if ($message->parent_id == null && $message->rating != 2 && $message->rating != 1)
                                                        <div class="customer_feedback">
                                                            <div class="cus_profile">
                                                                <h6>
                                                                    <img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}" alt="">
                                                                    {{ $message->user->name }}
                                                                </h6>
                                                                @if ($message->rating == 1)
                                                                    <span class="mess_icon_p">
                                                                @elseif ($message->rating == 2)
                                                                    <span class="mess_icon_n">
                                                                @else
                                                                    <span class="mess_icon_ng">
                                                                @endif
                                                            </div>
                                                            <p class="feedback_c">{{ $message->message }}</p>
                                                            <div class="dtr_text">
                                                                <p>
                                                                    {{ date('dS M, Y', strtotime($message->created_at)) }}
                                                                    @if (auth()->check())
                                                                        <span class="replyBtn">Reply</span>
                                                                    @endif
                                                                </p>
                                                                <div class="reply" style="display: none">
                                                                    <form method="post" action="{{ route('feedbackProcess') }}">
                                                                        {{ csrf_field() }}
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="message" class="form-control" required>
                                                                            <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : 0 }}">
                                                                            <input type="hidden" name="seller_id" value="{{ $message->seller_id }}">
                                                                            <input type="hidden" name="parent_id" value="{{ $message->id }}">
                                                                            <input type="hidden" name="rating" value="{{ $message->rating }}">
                                                                            <div class="input-group-append">
                                                                                <button type="submit">
                                                                                    <span class="material-icons" style="font-size: 25px;display: flex;align-items: center;justify-content: center;">send</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @foreach ($data as $check)
                                                        @if ($check->parent_id == $message->id && $message->rating != 2 && $message->rating != 1)
                                                            <div class="user_feedback">
                                                                <div class="cus_profile">
                                                                    <h6>
                                                                        <img src="{{ $message->user->image == null ? asset('assets_frontend/img/ic-11.png') : asset('uploads/profile/' . $message->user->image) }}" alt="">
                                                                        {{ $check->user->name }}
                                                                    </h6>
                                                                </div>
                                                                <p class="feedback_c">{{ $check->message }}</p>
                                                            </div>
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-pg-rt">
                        <div class="list-rhs-form pglist-bg pglist-p-com ">
                            <div class="fbpr_area">
                                <span class="feedm_icanh"></span>
                                <p>Your feedback is very important for the seller review. Please, leave the honest review to help other buyers and the seller in the customer attraction.</p>
                            </div>
                        </div>
                        @if (auth()->check() && $seller->id == auth()->user()->id)
                            <div class="list-rhs-form pglist-bg pglist-p-com makeOfferBox">
                                <div class="quote-pop grens">
                                    <h3 style="background:#20334c;">Send Feedback Link To Customer</h3>
                                    <div class="pl-left myOfferForm_val" style="padding-left: 5px;padding-right: 1px;">
                                        <form method="post" action="{{ route('feedbackMail') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" placeholder="Enter User Name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" placeholder="Enter User Email" required>
                                            </div>
                                            <button class="btn btn-primary" style="background:#20334c;">Send Link</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal --}}
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body feedmodal">
                        <form method="post" action="{{ route('feedbackProcess') }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault01">Message</label>
                                    <textarea name="message" id="" cols="100" rows="100" class="form-control" required></textarea>
                                    <input type="hidden" name="user_id"
                                        value="{{ auth()->check() ? auth()->user()->id : 0 }}">
                                    <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <ul class="ratsul">
                                        <li>
                                            <input type="radio" id="f-option" name="rating" value="1">
                                            <label for="f-option"><span class="mess_icon"></span> Postive</label>
                                            <div class="check"></div>
                                        </li>
                                        <li>
                                            <input type="radio" id="s-option" name="rating" value="2">
                                            <label for="s-option"><span class="mess_icon"></span> Neutral</label>
                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="t-option" name="rating" value="3">
                                            <label for="t-option"><span class="mess_icon"></span>Negative</label>
                                            <div class="check">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-center pb-4">
                                <button class="btn btn-primary sbfeeds" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Modal --}}
@endsection

@section('customScripts')
        <script>
            $(document).ready(function() {
                $('.reply').hide();
                $(document).on('click', '.replyBtn', function() {
                    $(this).parents('.dtr_text').find('.reply').toggle();
                });
            });
        </script>
@endsection
