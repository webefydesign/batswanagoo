@extends('layouts.frontend')

@section('title', 'Select Your Plan Type' . ' | Batswana Goo')

@section('content')
    <div class="m-container" style="margin-bottom: 60px;">
        <div class="container">
            <h1> Increase your sales with Batswana Goo Premium Services! </h1>
        </div>

        <section class="pay-a">
            <div class="container">

                <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-center mt-4">Choose the right category for your ads and start selling faster</h4>
                    <ul class="else-ul mb-5">
                        @if(isset($plan_types))
                            @foreach($plan_types as $k => $plan_type)
                                <li>
                                    <a href="{{route('select_plan', $plan_type->name)}}" class="b-carsbtn">
                                    <span>
                                        @if(isset($plan_type->image))
                                            <div class="borders"><img src="{{ url($plan_type->image) }}"></div>
                                        @endif
                                        <em><small>Boost Sales in</small> {{$plan_type->name}}</em>
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="hoss">
                        <a href="{{url('how-it-works')}}">How does it work?</a>
                    </div>

                </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('customScripts')
@endsection
