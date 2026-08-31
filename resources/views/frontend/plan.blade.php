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
    width: 100%;
    }
</style>
<style>
    .pricing-section{
    padding:40px 0;
}

.pricing-title{
    font-size:42px;
    font-weight:700;
    color:#222;
    margin-bottom:10px;
}

.pricing-subtitle{
    color:#6c757d;
    font-size:15px;
    line-height:1.6;
}

.category-label{
    display:block;
    font-size:13px;
    font-weight:600;
    margin-bottom:8px;
}

.category-select{
    height:52px;
    border-radius:30px;
    border:1px solid #e5e5e5;
    padding-left:20px;
    box-shadow:none;
}

.plan-card{
    background:#fff;
    border:1px solid #e7e7e7;
    border-radius:16px;
    padding:18px;
    height:100%;
    position:relative;
    box-shadow:0 3px 12px rgba(0,0,0,.04);
}

.current-plan{
    border:2px solid #41b649;
}

.plan-header{
    text-align:center;
    margin-bottom:20px;
}

.plan-header h3{
    font-size:36px;
    font-weight:700;
    margin:0;
}

.plan-header.basic h3{
    color:#f39c12;
}

.plan-header.vip h3{
    color:#41b649;
}

.plan-badge{
    display:inline-block;
    background:#41b649;
    color:#fff;
    font-size:11px;
    padding:4px 10px;
    border-radius:30px;
    margin-top:8px;
}

.popular-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #f39c12;
    color: #fff;
    padding: 11px 14px 1px 14px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 500;
}

.plan-price{
    text-align:center;
    border-bottom:1px solid #eee;
    padding-bottom:18px;
    margin-bottom:18px;
}

.plan-price strong{
    font-size:24px;
    font-weight:700;
}

.plan-price span{
    color:#666;
    font-size:13px;
}

.plan-features{
    list-style:none;
    padding:0;
    margin:0 0 25px;
}

.plan-features li{
    margin-bottom:14px;
    font-size:14px;
    color:#222;
}

.plan-features li.disabled{
    color:#9ea3a8;
}

.btn-current{
    background:#eef7ef;
    color:#41b649;
    font-weight:600;
}

.compare-card{
    background:#fff;
    border:1px solid #e7e7e7;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 3px 12px rgba(0,0,0,.04);
}

.compare-header{
    font-weight:700;
    font-size:18px;
    padding:18px;
    border-bottom:1px solid #eee;
}

.compare-table th{
    font-size:12px;
    font-weight:700;
    border-top:none;
}

.compare-table td{
    font-size:13px;
    vertical-align:middle;
}

.plan-note{
    margin-top:25px;
    text-align:center;
    background:#f5faf5;
    border-radius:12px;
    padding:14px;
    color:#666;
    font-size:14px;
}
.pricing-layout{
    display:flex;
    gap:25px;
    align-items:flex-start;
}

.plans-wrapper {
    flex: 0 0 65%;
    min-width: 0;
    position: sticky;
    margin-top: 6px;
    top: 122px;
    position: -webkit-sticky;
}

.compare-wrapper{
    flex:0 0 35%;
}

.plans-scroll{
    display:flex;
    gap:20px;
    overflow-x:auto;
    padding-bottom:15px;
    scroll-behavior:smooth;
}

.plans-scroll::-webkit-scrollbar{
    height:8px;
}

.plans-scroll::-webkit-scrollbar-thumb{
    background:#d7d7d7;
    border-radius:30px;
}

.plans-scroll::-webkit-scrollbar-track{
    background:#f5f5f5;
}

.plans-scroll .plan-card{
    min-width:380px;
    max-width:380px;
    flex-shrink:0;
}

.compare-wrapper .compare-card{
    position:sticky;
    top:20px;
}

@media(max-width:991px){

    .pricing-layout{
        flex-direction:column;
    }

    .plans-wrapper,
    .compare-wrapper{
        flex:0 0 100%;
        width:100%;
    }

    .plans-scroll .plan-card{
        min-width:320px;
    }

    .compare-wrapper .compare-card{
        position:relative;
        top:auto;
    }
}

.compare-check { color: #41b649; font-weight: 700; }
.compare-cross  { color: #ccc; }
.compare-table td { padding: 10px 18px; font-size: 13px; border-bottom: 1px solid #f3f4f6; }
.compare-table td:first-child { color: #6b7280; }
.compare-table td:last-child  { text-align: right; font-weight: 600; }
.compare-table tr.cat-row td  { background: #f9fafb; font-size: 12px; }
.compare-table tr.cat-row td:first-child { padding-left: 30px; color: #9ca3af; }
</style>
@endpush

@section('content')
    <div class="m-container" style="margin-bottom: 60px;">
        <div class="container">
            <section class="pricing-section">

                <div class="row align-items-start mb-4">
            
                    <div class="col-lg-7">
                        <h2 class="pricing-title">Choose Your Plan</h2>
                        <p class="pricing-subtitle">
                            Select a category and choose the plan that works best for you.
                        </p>
                    </div>
            
                    <div class="col-lg-3 ml-auto">
                        <label class="category-label">Select Category</label>
            
                        <select class="form-control category-select" onchange="window.location.href=this.value">
                            @foreach ($morePlan as $mp)
                                <option
                                    value="{{ route('select_plan', $mp->name) }}"
                                    @if($mp->id === $plan_type->id) selected @endif
                                >{{ $mp->name }}</option>
                            @endforeach
                        </select>
                    </div>
            
                </div>
            
                <div class="pricing-layout">
            
                    <!-- LEFT SIDE -->
                    <div class="plans-wrapper">
            
                        <div class="plans-scroll" id="plansScroll">
                            @if(isset($grouped))
                                @foreach($grouped as $k => $group)
                                    @php $plan_category_organized = getPlanCategory($group['plans']); @endphp
                                    @foreach($group['plans'] as $pk => $plan)
                                        @php
                                            $isActive  = isset($userPlan) && $userPlan->plan_id === $plan['id'];
                                            $isFirst   = !isset($userPlan) && $pk === array_key_first($group['plans']);
                                            $slugClass = strtolower(str_replace(' ', '-', $plan['name'])) . '-name';
                                        @endphp
                                        <div
                                            class="plan-card {{ $isActive ? 'current-plan' : '' }} {{ ($isActive || $isFirst) ? 'active-plan-card' : '' }}"
                                            data-plan-id="{{ $plan['id'] }}"
                                            data-plan-name="{{ $plan['slug'] }}"
                                            data-plan-price="{{ $plan['price'] }}"
                                            data-plan-label="{{ $plan['name'] }}"
                                        >
                                            {{-- Badge --}}
                                            @if($isActive)
                                                <span class="popular-badge" style="background:#41b649">Current Plan</span>
                                            {{-- @elseif($pk === array_key_first($group['plans']))
                                                <span class="popular-badge">MOST POPULAR</span> --}}
                                            @endif
                        
                                            <div class="plan-header {{ $slugClass }}">
                                                <h3>{{ strtoupper($plan['name']) }}</h3>
                                                @if($isActive)
                                                    <span class="plan-badge">Active
                                                        @if(isset($userPlan->plan_expire_date))
                                                            · Expires {{ $userPlan->plan_expire_date }}
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                        
                                            <div class="plan-price">
                                                <strong>{{ baseSymbol() }} {{ number_format($plan['price']) }}</strong>
                                                @if($plan['price']>0) 
                                                <span>/ {{ $group['month'] }} month</span>
                                                @endif
                                            </div>
                        
                                            {{-- Dynamic feature list --}}
                                            <ul class="plan-features">
                                                @if(isset($plan_type->points))
                                                    @foreach($plan_type->points as $i => $label)
                                                        @php $pt = $plan['points'][$i] ?? null; @endphp
                                                        <li class="{{ (!isset($pt) || $pt['include'] === 'no' || !isset($pt['include'])) ? 'disabled' : '' }}">
                                                            @if(isset($pt['include']) && $pt['include'] === 'yes')
                                                                ✓ {{ $label }}
                                                            @elseif(isset($pt['include']) && $pt['include'] === 'text')
                                                                ✓ {{ $pt['text'] ?? $label }}
                                                            @else
                                                                ✕ {{ $label }}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                @endif
                                                <li class="{{ $plan['media_links'] != 1 ? 'disabled' : '' }}">
                                                    {{ $plan['media_links'] == 1 ? '✓' : '✕' }} Website / Social Link
                                                </li>
                                                <li class="{{ $plan['dedicated_link'] != 1 ? 'disabled' : '' }}">
                                                    {{ $plan['dedicated_link'] == 1 ? '✓' : '✕' }} Dedicated Link
                                                </li>
                                                <li class="{{ $plan['sms'] != 1 ? 'disabled' : '' }}">
                                                    {{ $plan['sms'] == 1 ? '✓' : '✕' }} SMS Notifications
                                                </li>
                                                <li><a href="javascript:;" class="text-success"
                                                    data-plan-id="{{ $plan['id'] }}"
                                                    data-plan-name="{{ $plan['slug'] }}"
                                                    data-plan-price="{{ $plan['price'] }}"
                                                    data-plan-label="{{ $plan['name'] }}"
                                                    data-media-links="{{ $plan['media_links'] }}"
                                                    data-dedicated-link="{{ $plan['dedicated_link'] }}"
                                                    data-sms="{{ $plan['sms'] }}"
                                                    data-points='@json($plan["points"] ?? [])'
                                                    data-categories='@json($plan["PlanCategory"] ?? [])'
                                                    data-point-labels='@json($plan_type->points ?? [])'
                                                    onclick="selectPlan(this)">- See All Features</a></li>
                                            </ul>
                        
                                            {{-- CTA Button --}}
                                            @if($isActive)
                                                <button class="btn btn-current btn-block" type="button">Current Plan</button>
                                            @else
                                                @if($plan['price']==0) 
                                                    <button
                                                        class="btn btn-success btn-block bndolar"
                                                        type="button"
                                                        data-price="{{ $plan['price'] }}"
                                                        data-id="{{ $plan['id'] }}"
                                                        data-name="{{ $plan['slug'] }}"
                                                    >
                                                        Choose {{ $plan['name'] }}
                                                    </button>
                                                @else                                            
                                                    <button
                                                        class="btn btn-success btn-block bndolar"
                                                        type="button"
                                                        data-price="{{ $plan['price'] }}"
                                                        data-id="{{ $plan['id'] }}"
                                                        data-name="{{ $plan['slug'] }}"
                                                    >
                                                        Choose {{ $plan['name'] }}
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
            
                    </div>
            
                    <!-- RIGHT SIDE -->
                    <div class="compare-wrapper">
                        <div class="compare-card">
                            <div class="compare-header">
                                Plan Details &nbsp;<span id="comparePlanName" style="color:#41b649;font-size:14px;font-weight:600"></span>
                            </div>
                            <table class="table compare-table mb-0">
                                <tbody id="compareBody">
                                    <tr><td colspan="2" style="text-align:center;padding:30px;color:#9ca3af">Click on <b>See All Features</b> to see its details</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            
                </div>
            
            </section>

        </div>
        <div class="container d-none">
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

    {{-- Hidden payment form --}}
    @php
    $first_value = $grouped[array_key_first(array($grouped))];
    $plan_id = isset($userPlan->plan_id) ? $userPlan->plan_id
        : ($first_value['plans'][array_key_first($first_value['plans'])]['id'] ?? 0);
    $plan_name = isset($userPlan->plan_name) ? $userPlan->plan_name
        : ($first_value['plans'][array_key_first($first_value['plans'])]['id'] ?? 0);
    @endphp
    <form action="{{ route('plan.active') }}" id="planActiveForm" method="post" style="display:none">
    {{ csrf_field() }}
    <input type="hidden" name="plan_id"    value="{{ $plan_id }}">
    <input type="hidden" name="plan_name"  value="{{ $plan_name }}">
    <input type="hidden" name="plan_type"  value="{{ $plan_type->id }}">
    <input type="hidden" name="plan_month" value="1">
    <input type="hidden" name="price"      value="0">
    </form>
@endsection

@section('customScripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    let elements, card, clientSecret;
    
    /* ── Select plan: update hidden form + compare panel ── */
    function selectPlan(el) {
        // Update active card styling
        document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active-plan-card'));
        el.classList.add('active-plan-card');
    
        const id    = el.dataset.planId;
        const name  = el.dataset.planName;
        const price = el.dataset.planPrice;
        const label = el.dataset.planLabel;
    
        // Update hidden form inputs
        document.querySelector('#planActiveForm input[name="plan_id"]').value   = id;
        document.querySelector('#planActiveForm input[name="plan_name"]').value  = name;
        document.querySelector('#planActiveForm input[name="price"]').value     = price;
    
        // Build compare panel
        buildComparePanel(el, label);
    }
    
    function buildComparePanel(el, label) {
        document.getElementById('comparePlanName').textContent = label.toUpperCase();
    
        const points      = JSON.parse(el.dataset.points || '[]');
        const pointLabels = JSON.parse(el.dataset.pointLabels || '[]');
        const categories  = JSON.parse(el.dataset.categories || '[]');
        const mediaLinks  = el.dataset.mediaLinks == '1';
        const dedicatedLink = el.dataset.dedicatedLink == '1';
        const sms         = el.dataset.sms == '1';
        const price       = parseFloat(el.dataset.planPrice || 0);
    
        let rows = '';
    
        // Price row
        rows += `<tr>
            <td>Price</td>
            <td>{{ baseSymbol() }} ${number_format(price, 0)}</td>
        </tr>`;
    
        // Dynamic points
        pointLabels.forEach((lbl, i) => {
            const pt = points[i] || {};
            let val = '';
            if (pt.include === 'yes')        val = '<span class="compare-check">✓</span>';
            else if (pt.include === 'text')  val = pt.text || '—';
            else                             val = '<span class="compare-cross">✕</span>';
            rows += `<tr><td>${lbl}</td><td>${val}</td></tr>`;
        });
    
        // Listings in categories header row
        if (categories.length) {
            rows += `<tr><td><strong>Listings by Category</strong></td><td></td></tr>`;
            categories.forEach(cat => {
                const catName = (cat.category && cat.category.name) ? cat.category.name : ('Category ' + cat.category_id);
                const adsVal  = cat.unlimited == 1 ? '<span class="compare-check">Unlimited</span>'
                              : (cat.ads ? cat.ads + ' ads' : '0 ads');
                rows += `<tr class="compare-category-rows"><td>${catName}</td><td>${adsVal}</td></tr>`;
            });
        }
    
        // Fixed features
        rows += `
            <tr><td>Website / Social Link</td><td>${mediaLinks   ? '<span class="compare-check">✓</span>' : '<span class="compare-cross">✕</span>'}</td></tr>
            <tr><td>Dedicated Link</td>       <td>${dedicatedLink ? '<span class="compare-check">✓</span>' : '<span class="compare-cross">✕</span>'}</td></tr>
            <tr><td>SMS Notifications</td>    <td>${sms           ? '<span class="compare-check">✓</span>' : '<span class="compare-cross">✕</span>'}</td></tr>
        `;
    
        document.getElementById('compareBody').innerHTML = rows;
    }
    
    /* ── Toggle category list inside card ── */
    function toggleCategoryList(e, btn) {
        e.stopPropagation();
        btn.classList.toggle('open');
        btn.nextElementSibling.classList.toggle('open');
    }
    
    /* ── Buy Now (on Upgrade button click) ── */
    $(document).on('click', '.bndolar', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var planPrice = parseFloat($(this).data('price') || 0);
        var planId    = $(this).data('id');
        var planName  = $(this).data('name');

        // Update hidden form inputs from the clicked button
        $('input[name="plan_id"]').val(planId);
        $('input[name="plan_name"]').val(planName);
        $('input[name="price"]').val(planPrice);

        var walletBalance = parseFloat('{{ auth()->user()->wallet->balance ?? 0 }}');
        var baseSymbol    = '{{ baseSymbol() }}';
        var deductAmount  = Math.min(walletBalance, planPrice);
        var remainingAmount = Math.max(planPrice - walletBalance, 0);

        $('#modal-plan-name').text(planName.toUpperCase());
        $('#modal-plan-price').text(number_format(planPrice, 2));
        $('#modal-wallet-balance').text(number_format(walletBalance, 2));
        $('.modal-remaining-amount').text(number_format(remainingAmount, 2));

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
        $('#purchasePlanModal').modal('show');
    });

    /* ── Purchase via AJAX ── */
    $(document).on('click', '#purchasePlanBtn', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).text('Processing...');

        var formData = new FormData($('#planActiveForm')[0]);
        var _url     = $('#planActiveForm').attr('action');

        $.ajax({
            url: _url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.error) {
                    Swal.fire('Error', data.error, 'error');
                    $btn.prop('disabled', false).text('Try Again');
                    return;
                }
                if (data.type === 'stripe') {
                    clientSecret = data.clientSecret;
                    $('#stripeDiv').slideDown();
                    $('#payment-summary').slideUp();
                    if (!elements) {
                        elements = stripe.elements();
                        card = elements.create('card', {
                            hidePostalCode: true,
                            style: { base: { fontSize: '16px', color: '#32325d' } }
                        });
                        card.mount('#card-element');
                    }
                } else if (data.type === 'wallet') {
                    $('#planSuccessPlanId').val(data.plan_id);
                    $('#planPaymentType').val(data.type);
                    $('#planStripeSuccessForm').submit();
                }
            },
            error: function(xhr) {
                var errorMsg = 'Payment processing failed.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                Swal.fire('Error', errorMsg, 'error');
                $btn.prop('disabled', false).text('Try Again');
            }
        });
    });

    /* ── Stripe card payment ── */
    $('#payment-form').on('submit', function(e) {
        e.preventDefault();
        var $payBtn = $('#payBtn');
        $payBtn.prop('disabled', true).text('Processing Payment...');

        stripe.confirmCardPayment(clientSecret, {
            payment_method: { card: card }
        }).then(function(result) {
            if (result.error) {
                Swal.fire('Error', result.error.message, 'error');
                $payBtn.prop('disabled', false).text('Pay Now');
            } else if (result.paymentIntent.status === 'succeeded') {
                $('#payment_intent').val(result.paymentIntent.id);
                $('#planStripeSuccessForm').submit();
            }
        });
    });

    /* ── Reset modal on close ── */
    $('#purchasePlanModal').on('hidden.bs.modal', function() {
        $('#payment-summary').show();
        $('#stripeDiv').hide();
        $('#purchasePlanBtn').prop('disabled', false);
        if (card) card.clear();
    });
    
    function number_format(n, d) {
        return parseFloat(n).toFixed(d).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    /* ── Auto-select the first active card on load ── */
    document.addEventListener('DOMContentLoaded', function() {
        const activeCard = document.querySelector('.plan-card.active-plan-card');
        if (activeCard) selectPlan(activeCard);
    });
</script>
@endsection
