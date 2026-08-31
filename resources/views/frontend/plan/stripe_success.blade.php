@extends('layouts.frontend')
@section('title', 'Plan Purchase Successfully | Batswana Goo')
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
        #planSuccessDiv {
            border: 1px solid #3aaf38;
            margin: 150px auto 50px auto;
            padding: 10px;
            border-radius: 20px;
        }
        #planSuccessDiv h4 {
            color: #3aaf38;
        }
        #planSuccessDiv p {
            color: #000;
        }
        #planSuccessDiv a {
            background: #3aaf38;
            border-radius: 10px;
            border: 1px solid #fff;
        }
        @media screen and (max-width: 768px) {
            #planSuccessDiv {
                margin: 80px auto 40px auto;
            }
            #planSuccessDiv a {
                background: transparent;
                border-radius: 10px;
                border: 1px solid #3aaf38;
                color: #000;
                padding: 10px;
                font-size: 12px;
                font-weight: 500;
            }
        }
    </style>
@endsection
@section('content')

    <!-- Breadscrumb Section -->
        {{-- <section class="all-list-bre searchbanner" style="background-image: url('{{ url('assets_frontend/img/electronices.jpg') }}');">
            <div class="container sec-all-list-bre">
                <div class="row">
                    <ul>
                        <li><a href="{{route('home')}}">Back to Home</a></li>
                        <li><span>Plan Purchased</span></li>
                    </ul>
                    <h2 style="visibility: hidden;">Plan Purchased</h2>
                    <h1>Plan Purchased</h1>
                </div>
            </div>
        </section> --}}
	<!-- /Breadscrumb Section -->

    <div class="container">
        <section id="planSuccessDiv">
            <div class="bot-book">
                <div class="row">
                    <div class="col-md-12 bb-text">
                        <h4>Plan Purchase Confirmation</h4>
                        <p>Congratulations on purchasing <b style="font-weight: bold;"><i>{{ $plan->plantype->name??'' }} ({{ $plan['plan_name'] }})</i></b> plan for <b style="font-weight: bold;">{{ $plan['plan_month'] }}</b> months. Your plan will expiry on <b style="font-weight: bold;">{{ Carbon\Carbon::parse($plan['plan_expire_date'])->format('d, F Y') }}</b></p>
                        <p>We appreciate your business and will do our best to ensure a smooth processing and delivery of your order. If you have any questions or require further assistance, please don't hesitate to reach out to our customer support team. Thank you for choosing us, and we look forward to serving you!</p>
                        <a href="{{route('postAdd')}}">Post An Ad <i class="material-icons" style="margin-left: 0px;width: 38px;">arrow_forward</i>  </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('customScripts')
@endsection
