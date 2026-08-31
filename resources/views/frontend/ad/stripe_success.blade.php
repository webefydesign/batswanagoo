@extends('layouts.frontend')
@section('title', 'Promotion Purchase Confirmation | Salone Goo')
@section('customStyles')
    <style>
        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
            .page-not-found h2 {
                font-size: 40px;
            }
            .page-not-found h3 {
                margin-bottom: 2em;
            }
        }
        .thanks {
            background: url({{url('/public/img/abt-sec2-bg.png')}})no-repeat 0 0;
            background-size: cover;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: -30px;
            text-align: center;
        }
        .thanks h2 {
            color: #322d4d;
            margin-bottom: 23px;
            border-top: 5px solid #df965e;
            border-bottom: 5px solid #df965e;
            font-size: 39px;
            text-transform: capitalize;
            padding: 13px 0;
            display: inline-block;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: #333;
            font-size: 24px;
            margin-top: 0;
        }
        .thanks p {
            text-align: center;
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .thankWrapper {
            padding: 68px;
            background: #fff;
        }
        .btn-home {
            background-color: #374b5c;
            border: 1px solid #374b5c;
            align-items: center;
            color: #fff;
            box-shadow: inset 0 0 0 #fff;
            border-radius: 4px;
            padding: 11px 19px;
            font-weight: 600;
            text-align: center;
            -webkit-transition: all 0.7s;
            -moz-transition: all 0.7s;
            -o-transition: all 0.7s;
            transition: all 0.7s;
            line-height: normal;
        }
        .btn-home:hover{
            border: 1px solid #374b5c;
            color: #374b5c;
            background-color: #fff;
            box-shadow: inset 0 70px 0 0 #ffffff;
            -webkit-transition: all 0.7s;
            -moz-transition: all 0.7s;
            -o-transition: all 0.7s;
            transition: all 0.7s;
        }
        .promotion {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            color: #000;
            float: none !important;
        }
        .promotion-title {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')

    <!-- Breadscrumb Section -->
        <section class="all-list-bre searchbanner" style="background-image: url('{{ url('assets_frontend/img/electronices.jpg') }}');">
            <div class="container sec-all-list-bre">
                <div class="row">
                    <ul>
                        <li><a href="{{route('home')}}">Back to Home</a></li>
                        <li><span>Promotions Purchased</span></li>
                    </ul>
                    <h2 style="visibility: hidden;">Promotions Purchased</h2>
                    <h1>Promotions Purchased</h1>
                </div>
            </div>
        </section>
	<!-- /Breadscrumb Section -->

    <section>
        <div class="full-bot-book" style="background-image: url('{{ url('assets_frontend/img/electronices.jpg') }}');background-size: cover;background-position: center center;">
           <div class="container">
              <div class="row">
                 <div class="bot-book">
                    <div class="col-md-12 bb-text">
                        <h1>Promotion Purchase Confirmation</h1>
                        <p>Dear {{ $ad->user->name }},</p>
                        @if(isset($ad->promotions))
                            @foreach($ad->promotions as $promote)
                                <div class="promotion">
                                    <p class="promotion-title">{{ $promote['promo_name'] }}</p>
                                    <p><strong>Duration:</strong> {{ $promote['days'] }}</p>
                                    <p><strong>Start Date:</strong> 14th March 2025, 07:08 AM {{ Carbon\Carbon::parse($promote['start'])->format('d/m/Y h:i a') }}</p>
                                    <p><strong>End Date:</strong> 21st March 2025, 12:00 AM {{ Carbon\Carbon::parse($promote['end'])->format('d/m/Y h:i a') }}</p>
                                </div>
                            @endforeach
                        @endif
                        <p><strong>Ad Title:</strong> <em>{{ $ad['title'] }}</em></p>
                        <p>We truly appreciate your business. Rest assured, we’re committed to ensuring a smooth processing and effective display of your promotions.</p>
                        <p>If you have any questions or need assistance, please don’t hesitate to contact our customer support team.</p>
                        <p class="footer">
                            Best regards,<br>
                            <strong>{{ env('Website_Name') }}</strong><br>
                            <span>{{ getConfigurations()['contact_meta']['email'] }}</span><br>
                            <span>{{ getConfigurations()['contact_meta']['phone'] }}</span><br>
                            <span>{{ getConfigurations()['contact_meta']['address'] }}</span>
                        </p>
                       <a href="{{route('home')}}"><i class="material-icons" style="margin-left: 0px;width: 38px;">arrow_backward</i> Back To Home </a>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>

@endsection

@section('customScripts')
@endsection
