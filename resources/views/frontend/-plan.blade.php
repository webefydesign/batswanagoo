@extends('layouts.frontend')

@section('title', 'Select Your Plan' . ' | Salone Goo')

@push('push_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css" integrity="sha256-Hr+pC4Itl2fpZpbgDovrP2OKWz72NVCWLXGRRJg/mAo=" crossorigin="anonymous">
<style>
    /* .labeltable{display:none;} */
    .yellow-td .labeltable{display:none;}
    .yellow-td .labeldate{display:none;}
    .label-td{position: relative;height:60px;align-items: flex-start;}
    .yellow-td{align-items: center;}
    .labeldate{
        font-size: 11px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-top: 8px;
        width: 100%;
        text-align: center;
    }
    .bndolar {
    width: 310px;
    }
</style>
@endpush

@section('content')
    <div class="m-container" style="margin-bottom: 60px;">
        <div class="container">
            {{-- <h1>Choose the plan in {{ $plan_type->name }} that works for you</h1> --}}
            <h1>Choose the plan in <div class="dropdown d-inline-block">
                <button class="btn btn-sm" style="background: transparent;color: #1cae38;font-weight: 600;font-size: 2rem;padding: 0px;font-style: italic;" 
                        type="button" 
                        id="categoryDropdown" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false">
                    <span class="nameCategory">{{ $plan_type->name }}</span>
                    <img src="{{asset('assets_frontend/img/icon/down-arrow.svg')}}" style="width: 20px;margin-top: 1px;margin-left: 5px;">
                </button>
                <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                    @foreach ($morePlan as $plan)
                        <a class="dropdown-item fatchCategory" 
                           href="{{route('select_plan', $plan->name)}}" >
                           {{ $plan->name }}
                        </a>
                    @endforeach                                                                  
                </div>
            </div>


            </h1>            
        </div>

        <section class="planSection">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        {{-- @dd($userPlan) --}}
                        <form action="{{ route('plan.active') }}" class="planActiveForm" id="planActiveForm" method="post">
                            {{ csrf_field() }}

                            @php
                                $first_value = $grouped[array_key_first(array($grouped))];
                                $plan_id = 0;
                                $plan_name = '';
                                if(isset($userPlan->plan_id)){
                                    $plan_id = $userPlan->plan_id;
                                }else{
                                    $plan_id = ($first_value['plans'][array_key_first(array($first_value['plans']))] != null) ? $first_value['plans'][array_key_first(array($first_value['plans']))]['id']: 0;
                                }

                                if(isset($userPlan->plan_name)){
                                    $plan_name = $userPlan->plan_name;
                                }else{
                                    $plan_name = ($first_value['plans'][array_key_first(array($first_value['plans']))] != null) ? $first_value['plans'][array_key_first(array($first_value['plans']))]['id']: 0;
                                }
                            @endphp

                            <input 
                                type="hidden" 
                                name="plan_id" 
                                value="{{ ($plan_id)??0 }}"
                            >
                            <input type="hidden" name="plan_name" value="{{ ($plan_name)??'' }}">
                            <input type="hidden" name="plan_type" value="{{ $plan_type->id }}">
                            {{-- Temporary --}}
                            <input type="hidden" id="month1" name="plan_month" value="1">
                            {{-- Temporary --}}

                            <div class="planFeatureTable">
                                {{-- <div class="monthlypaks">
                                    <ul class="mnthpack">
                                        @if(isset($grouped))
                                            @foreach($grouped as $k => $group)
                                                <li>
                                                    <input 
                                                        type="radio" 
                                                        id="month{{$group['month']}}" 
                                                        name="plan_month" 
                                                        value="{{$group['month']}}" 
                                                        @if(isset($userPlan) && $userPlan->plan_month === $group['month']) 
                                                            checked
                                                        @else 
                                                            @if(!isset($userPlan) && $k === array_key_first($grouped)) checked @endif
                                                        @endif 
                                                        class="monthBtn"
                                                    >
                                                    <label for="month{{$group['month']}}">{{$group['month']}} Month</label>
                                                    <div class="check">@if($k !== array_key_first($grouped)) <div class="inside"></div> @endif</div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div> --}}

                                @if(isset($grouped))
                                    @foreach($grouped as $k => $group)
                                        <div 
                                            id="{{ $group['month'] }}" 
                                            @if(isset($userPlan) && $userPlan->plan_month === $group['month']) 
                                                class="monthDiv" 
                                            @else 
                                                @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) class="monthDiv" @else class="monthDiv d-none" @endif 
                                            @endif
                                        >
                                            <table class="table">
                                                <thead>
                                                    <tr class="aa-package-names">
                                                        <th class="cell-width"></th>
                                                        @if(isset($group['plans']))
                                                            @foreach($group['plans'] as $k => $plan)
                                                                <th 
                                                                    class="
                                                                        cell-width 
                                                                        aa-col-plan 
                                                                        aa-col-plan-{{strtolower(str_replace(' ','-',$plan['name']))}} 
                                                                        @if(isset($userPlan) && $userPlan->plan_id === $plan['id']) 
                                                                            aa-active 
                                                                        @else 
                                                                            @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif 
                                                                        @endif
                                                                    " 
                                                                    data-price="{{ $plan['price'] }}" 
                                                                    data-id="{{ $plan['id'] }}"
                                                                >
                                                                    <input 
                                                                        type="radio" 
                                                                        @if(isset($userPlan) && $userPlan->plan_id === $plan['id']) 
                                                                            checked 
                                                                        @else  
                                                                            @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) checked @endif 
                                                                        @endif
                                                                        id="aa-selected-plan-{{strtolower(str_replace(' ','-',$plan['name']))}}" 
                                                                        name="plan" 
                                                                        value="{{$plan['id']}}" 
                                                                    />
                                                                    <div 
                                                                        class="label-td 
                                                                            @if(isset($userPlan) && $userPlan->plan_id === $plan['id']) 
                                                                                
                                                                            @else  
                                                                                @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) @else yellow-td @endif 
                                                                            @endif
                                                                        "
                                                                    >
                                                                        {{$plan['name']}}
                                                                        {{-- @if($k === array_key_first(array($group['plans']))) --}}
                                                                            <p><strong class="labeltable">active</strong></p>
                                                                            @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                                <p class="labeldate"><strong>{{ $userPlan->plan_expire_date }}</strong></p>
                                                                            @endif
                                                                        {{-- @endif --}}
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                    <tr class="aa-package-prices">
                                                        <th class="big-cell"></th>
                                                        @if(isset($group['plans']))
                                                            @foreach($group['plans'] as $k => $plan)
                                                                <th 
                                                                    class="
                                                                        big-cell 
                                                                        aa-col-plan 
                                                                        aa-col-plan-{{strtolower(str_replace(' ','-',$plan['name']))}} 
                                                                        @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                            aa-active
                                                                        @else
                                                                            @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                        @endif
                                                                        
                                                                    " 
                                                                    data-price="{{ $plan['price'] }}" 
                                                                    data-id="{{ $plan['id'] }}"
                                                                >
                                                                    <div class="price-td">{{ baseSymbol() }} {{ number_format($plan['price']) }}</div>
                                                                </th>
                                                            @endforeach
                                                            <input type="hidden" name="price" value="{{ ($group['plans'][array_key_first(array($group['plans']))]['price'])??0 }}" />
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if(isset($plan_type->points))
                                                            @foreach($plan_type->points as $i => $value)
                                                                <tr class="aa-feature aa-feature-1">
                                                                    <td class="clientsmore">
                                                                        <div class="plan--title">
                                                                            {{$value}}
                                                                        </div>
                                                                    </td>
                                                                    @foreach ($group['plans'] as $k => $plan)
                                                                        <td 
                                                                            class="
                                                                                clientsmore 
                                                                                aa-col-plan 
                                                                                aa-col-plan-{{ $plan['slug'] }}
                                                                                @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                                    aa-active
                                                                                @else
                                                                                    @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                                @endif
                                                                            " 
                                                                            data-price="{{ $plan['price'] }}" 
                                                                            data-id="{{ $plan['id'] }}"
                                                                        >
                                                                            <div class="cl-txt">
                                                                                @if(isset($plan['points'][$i]['include']) && $plan['points'][$i]['include'] == 'text')
                                                                                    <div>{{ $plan['points'][$i]['text'] }}</div>
                                                                                @elseif (isset($plan['points'][$i]['include']) && $plan['points'][$i]['include'] == 'yes')
                                                                                    <div><i class="material-icons clopme chcekcs">check</i></div>
                                                                                @else
                                                                                    <div><i class="material-icons clopme">close</i></div>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                    <tr class="aa-feature aa-feature-8">
                                                        <td class="clientsmore">
                                                            <div class="plan--title">
                                                                Listings in categories
                                                            </div>
                                                        </td>
                                                        @foreach ($group['plans'] as $k => $plan)
                                                            <td class="
                                                                    clientsmore 
                                                                    aa-col-plan 
                                                                    aa-col-plan-{{ $plan['slug'] }} 
                                                                    @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                        aa-active
                                                                    @else
                                                                        @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                    @endif
                                                                " 
                                                                data-price="{{ $plan['price'] }}" 
                                                                data-id="{{ $plan['id'] }}"
                                                            >
                                                                <div class="cl-txt">
                                                                    <div>
                                                                        <span class="plst-btn">
                                                                            <em class="sf-txt">See Full List</em>
                                                                            <em class="sh-txt">Hide List</em>
                                                                            <img src="{{ asset('assets_frontend/img/icon/down-arrow.svg') }}"></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>

                                                    @php
                                                        $plan_category_organized = getPlanCategory($group['plans']);
                                                    @endphp

                                                    @foreach ($plan_category_organized as $id => $categories)
                                                        @if($categories[0]['ads'] != null || $categories[0]['unlimited'] == 0)
                                                            <tr class="aa-feature aa-feature-9 categorylistp" style="">
                                                                <td class="clientsmore">
                                                                    <div class="plan--title">
                                                                        {{ $categories[0]['category']['name'] ?? null }}
                                                                    </div>
                                                                </td>
                                                                @foreach ($group['plans'] as $k => $plan)
                                                                    @php $cats = $plan['PlanCategory']; @endphp
                                                                        <td 
                                                                            class="
                                                                                clientsmore 
                                                                                aa-col-plan 
                                                                                aa-col-plan-{{ $plan['slug'] }} 
                                                                                @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                                    aa-active
                                                                                @else
                                                                                    @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                                @endif
                                                                            " data-price="{{ $plan['price'] }}" data-id="{{ $plan['id'] }}">
                                                                            @foreach($cats as $ca => $cat)
                                                                                @if($cat['category_id'] === $id)
                                                                                    @if (isset($cat) && $cat['unlimited'] == 1)
                                                                                        <div class="cl-txt">
                                                                                            <div class="bl-txts">Unlimited</div>
                                                                                        </div>
                                                                                    @elseif (isset($cat))
                                                                                        <div class="cl-txt">
                                                                                            <div class="bl-txts">{{ ($cat['ads'])??0 }} ads</div>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="cl-txt">
                                                                                            <div class="bl-txts">0 ads</div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                @endforeach
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    <tr class="aa-feature aa-feature-15">
                                                        <td class="clientsmore">
                                                            <div class="plan--title">
                                                                Website/social media link inclusion
                                                            </div>
                                                        </td>
                                                        @foreach ($group['plans'] as $k => $plan)
                                                            <td 
                                                                class="
                                                                    clientsmore 
                                                                    aa-col-plan 
                                                                    aa-col-plan-{{ $plan['slug'] }} 
                                                                    @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                        aa-active
                                                                    @else
                                                                        @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                    @endif
                                                                " data-price="{{ $plan['price'] }}" data-id="{{ $plan['id'] }}">
                                                                <div class="cl-txt">
                                                                    @if ($plan['media_links'] == 1)
                                                                        <div><i class="material-icons clopme chcekcs">check</i></div>
                                                                    @else
                                                                        <div><i class="material-icons clopme">close</i></div>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr class="aa-feature aa-feature-11">
                                                        <td class="clientsmore">
                                                            <div class="plan--title">
                                                                Dedicated Link
                                                            </div>
                                                        </td>
                                                        @foreach ($group['plans'] as $k => $plan)
                                                            <td 
                                                                class="
                                                                    clientsmore 
                                                                    aa-col-plan 
                                                                    aa-col-plan-{{ $plan['slug'] }} 
                                                                    @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                        aa-active
                                                                    @else
                                                                        @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                    @endif
                                                                " data-price="{{ $plan['price'] }}" data-id="{{ $plan['id'] }}">
                                                                <div class="cl-txt">
                                                                    @if ($plan['dedicated_link'] == 1)
                                                                        <div><i class="material-icons clopme chcekcs">check</i></div>
                                                                    @else
                                                                        <div><i class="material-icons clopme">close</i></div>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr class="aa-feature aa-feature-13">
                                                        <td class="clientsmore">
                                                            <div class="plan--title">
                                                                SMS notifications on new messages
                                                            </div>
                                                        </td>
                                                        @foreach ($group['plans'] as $k => $plan)
                                                            <td class="
                                                                    clientsmore 
                                                                    aa-col-plan 
                                                                    aa-col-plan-{{ str_replace(' ','-',$plan['slug']) }} 
                                                                    @if(isset($userPlan) && $userPlan->plan_id === $plan['id'])
                                                                        aa-active
                                                                    @else
                                                                        @if(!isset($userPlan) && $k === array_key_first(array($group['plans']))) aa-active @endif
                                                                    @endif
                                                                " data-price="{{ $plan['price'] }}" data-id="{{ $plan['id'] }}">
                                                                <div class="cl-txt">
                                                                    @if ($plan['sms'] == 1)
                                                                        <div><i class="material-icons clopme chcekcs">check</i></div>
                                                                    @else
                                                                        <div><i class="material-icons clopme">close</i></div>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="bus-pay">
                                                <button 
                                                    type="button" 
                                                    class="bndolar"
                                                >
                                                    <span>
                                                        <em>Buy Now</em>
                                                        <strong class="bndolarPrice">
                                                            <em style="font-weight:400;margin-right: 10px;">{{ baseSymbol() }} </em> 
                                                            <em class="btn-price">
                                                                @if(isset($userPlan))
                                                                    {{ ($userPlan->price)??0 }}
                                                                @else
                                                                    {{ $group['plans'][array_key_first($group['plans'])]['price'] }}
                                                                @endif
                                                                
                                                            </em>
                                                        </strong>
                                                    </span>
                                                </button>
                                                {{-- <button type="submit" class="bndolar"><span><em>Buy Now</em> <strong>{{ baseSymbol() }} <em class="btn-price ml-1">{{ $group['plans'][array_key_first($group['plans'])]['price'] }}</em></strong></span></button> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="pay-a">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="text-center">Selling something else?</h4>
                        <ul class="else-ul">
                            @foreach ($morePlan as $plan)
                                <li>
                                    <a href="{{route('select_plan', $plan->name)}}" class="b-carsbtn">
                                        <span>
                                            <div class="borders">
                                                <img src="{{ url(($plan->image)??'#') }}">
                                            </div>
                                            <em><small>Boost Sales in</small> {{ $plan->name }}</em>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="hoss">
                            <a href="{{url('how-it-works')}}">How does it work?</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

    <div id="purchasePlanModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
          <!-- Modal content-->
          <div class="modal-content" id="purchasePlanContent">
                <div class="modal-header">
                    <h4 class="modal-title text-success">Purchasing Plan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="payment-summary">
                        <table class="table table-bordered">
                            <tr>
                                <td>Plan Price (<span id="modal-plan-name"></span>)</td>
                                <td>{{ baseSymbol() }} <span id="modal-plan-price"></span></td>
                            </tr>
                            <tr>
                                <td>Wallet Balance</td>
                                <td>
                                    {{ baseSymbol() }} <span id="modal-wallet-balance">{{ auth()->user()->wallet->balance ?? 0.00 }}</span>
                                    <a href="{{ route('dashboard.wallet') }}" class="btn btn-outline-success btn-sm">Add Money</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Payable</td>
                                <td>
                                    {{ baseSymbol() }} <span class="modal-remaining-amount"></span>
                                </td>
                            </tr>
                        </table>
                        <div class="text-center">
                            <button id="purchasePlanBtn" class="btn btn-success mt-3"></button>
                        </div>
                    </div>
                    <div id="stripeDiv" style="display:none;">
                        {{-- <hr> --}}
                        <form id="payment-form">
                            <div id="card-element"></div>
                            <button id="payBtn" class="btn btn-success mt-3" type="submit">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="planStripeSuccessForm" class="d-none" action="{{ route('planSuccess') }}" method="GET">
        <input type="hidden" name="payment_intent" value="" id="payment_intent">
        <input type="hidden" name="plan_id" value="" id="planSuccessPlanId">
        <input type="hidden" name="type" value="stripe" id="planPaymentType">
    </form>
@endsection

@section('customScripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    let elements, card, clientSecret;
    
    $(document).ready(function() {
        $('.seebtn').on('click',function(){
            $('.seebtn').toggleClass('activeShow');
            $('.lstother').toggleClass('activelstother');
        });

        $('.plst-btn').on('click',function(){
            $('.plst-btn').toggleClass('activelstbtn');
            $('.categorylistp').toggleClass('activecategorylst');
        });

        $('.monthBtn').on('change', function() {
            var value = $(this).val();
            $('.monthDiv').addClass('d-none');
            $('#' + value).removeClass('d-none');
            var firstTd = $('#' + value).find('.table').find('thead .aa-package-names .aa-col-plan:first');
            firstTd.trigger('click');
        });

        $('.table').find('tr td').on('click',function(){
            //Add Class to First TD in ROW
            $('.table').find('.superStyle').removeClass('superStyle');
            $(this).closest('tr').find("td:nth-child(1)").addClass('superStyle');

            //Add Class to Header <th> Cell above
            $('.table').find('thead th').eq($(this).index()).addClass('superStyle')
            $('.table').find('thead tr:nth-child(2) th').eq($(this).index()).addClass('superStyle')
            $('.table').find('tbody tr td.clientsmore').eq($(this).index()).addClass('superStyle')
        });

        $('.aa-col-plan').on('click', function() {
            var price = $(this).data('price');
            var id = $(this).data('id');

            $('input[name="price"]').val(price);
            $('input[name="plan_id"]').val(id);

            $('.btn-price').html(number_format(price, 2));

            $('input[name="aa-selected-plan"]').prop('checked', false);
            $('.aa-col-plan').removeClass('aa-active');

            let plan = 'free';
            if($(this).hasClass('aa-col-plan-basic')) plan = 'basic';
            if($(this).hasClass('aa-col-plan-vip')) plan = 'vip';
            if($(this).hasClass('aa-col-plan-premium')) plan = 'premium';
            if($(this).hasClass('aa-col-plan-vip-gold')) plan = 'vip-gold';
            if($(this).hasClass('aa-col-plan-diamond')) plan = 'diamond';
            if($(this).hasClass('aa-col-plan-enterprise')) plan = 'enterprise';

            $('input[name="plan_name"]').val(plan);

            $('.aa-col-plan-' + plan).addClass('aa-active');
            $('.aa-col-plan').find('.label-td').addClass('yellow-td');
            $('.aa-col-plan-' + plan).find('.label-td').removeClass('yellow-td');
            $('input#aa-selected-plan-' + plan).prop('checked', true);
        });

        $('.bndolar').on('click', function (e) {
            e.preventDefault();

            var user_plan_id = '{{ ($userPlan->plan_id) ?? "" }}';
            var selected_plan = $('input[name="plan_id"]').val();

            if (user_plan_id === selected_plan) {
                Swal.fire({
                    title: "Already Purchased",
                    text: "You already have this plan. Please select a different plan.",
                    icon: "warning"
                });
                return;
            }

            // Get plan details
            var planName = $('input[name="plan_name"]').val();
            var planPrice = parseFloat($('input[name="price"]').val() || 0);
            var walletBalance = parseFloat('{{ auth()->user()->wallet->balance ?? 0 }}');
            var baseSymbol = '{{ baseSymbol() }}';

            // Calculate amounts
            var deductAmount = Math.min(walletBalance, planPrice);
            var remainingAmount = Math.max(planPrice - walletBalance, 0);

            // Update modal content
            $('#modal-plan-name').text(planName.toUpperCase());
            $('#modal-plan-price').text(number_format(planPrice, 2));
            $('#modal-wallet-balance').text(number_format(walletBalance, 2));
            $('.modal-remaining-amount').text(number_format(remainingAmount, 2));

            // Update button text based on wallet balance
            var btnText = '';
            if (walletBalance >= planPrice) {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(planPrice, 2) + ' from Wallet';
            } else if (walletBalance > 0) {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(deductAmount, 2) + ' (Wallet) + ' + 
                         baseSymbol + ' ' + number_format(remainingAmount, 2) + ' (Card)';
            } else {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(planPrice, 2) + ' (Card)';
            }
            
            $('#purchasePlanBtn').text(btnText);

            // Show modal
            $('#purchasePlanModal').modal('show');
        });

        $(document).on('click', '#purchasePlanBtn', function(){
            $(this).prop('disabled', true).text('Processing...');
            
            var formData = new FormData($('#planActiveForm')[0]);
            var _url = $("#planActiveForm").attr('action');
            
            $.ajax({
                url: _url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        $('#purchasePlanBtn').prop('disabled', false).text('Try Again');
                        return;
                    }
                    
                    if (data.type === 'stripe') {
                        // Need to collect card payment
                        clientSecret = data.clientSecret;
                        $('#stripeDiv').slideDown();
                        $('#payment-summary').slideUp();
                        
                        if (!elements) {
                            elements = stripe.elements();
                            card = elements.create('card', { 
                                hidePostalCode: true,
                                style: {
                                    base: {
                                        fontSize: '16px',
                                        color: '#32325d',
                                    }
                                }
                            });
                            card.mount('#card-element');
                        }
                    } else if (data.type === 'wallet') {
                        // Payment completed with wallet only
                        $('#planSuccessPlanId').val(data.plan_id);
                        $('#planPaymentType').val(data.type);
                        $('#planStripeSuccessForm').submit();
                    }
                },
                error: function (xhr) {
                    let errorMsg = 'Payment processing failed.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    Swal.fire('Error', errorMsg, 'error');
                    $('#purchasePlanBtn').prop('disabled', false).text('Try Again');
                    console.error(xhr.responseText);
                }
            });
        });

        $('#payment-form').on('submit', function (e) {
            e.preventDefault();
            $('#payBtn').prop('disabled', true).text('Processing Payment...');

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            }).then(function (result) {
                if (result.error) {
                    Swal.fire('Error', result.error.message, 'error');
                    $('#payBtn').prop('disabled', false).text('Pay Now');
                } else if (result.paymentIntent.status === 'succeeded') {
                    // Submit success form
                    $('#payment_intent').val(result.paymentIntent.id);
                    $('#planStripeSuccessForm').submit();
                }
            });
        });
        
        // Reset modal on close
        $('#purchasePlanModal').on('hidden.bs.modal', function () {
            $('#payment-summary').show();
            $('#stripeDiv').hide();
            $('#purchasePlanBtn').prop('disabled', false);
            
            if (card) {
                card.clear();
            }
        });
    });
    
    // Helper function for number formatting
    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection
