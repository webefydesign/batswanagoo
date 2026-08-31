@extends('layouts.frontend')
@section('title', 'My Adds | Batswana Goo')
@section('customStyles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .img_validation {
            background: #fff9ea;
            padding: 5px 10px;
            margin-bottom: 10px;
            font-size: 10px;
        }

        .fetching_fields {
            font-size: 13px;
            padding: 0px 0px 30px 0px;
        }

        .currency_input {
            position: relative;
        }

        .currency_input input {
            padding-left: 60px;
        }

        .currency_s {
            position: absolute;
            width: 50px;
            height: 42px;
            background: #1eaf38;
            color: white;
            z-index: 1;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
            font-size: 22px;
        }
        .charCount {
            position: absolute;
            color: #1eaf38;
            font-size: 11px;
            bottom: 29px;
            right: 10px;
            z-index: 999;
        }

        .charCount2 {
            bottom: 8px !important;
            right: 22px !important;
        }
        .drag-box-content {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
        .drag-box-content:hover {
            border-color: #1eaf38;
        }
        .drag-drop-box.dragging {
            border-color: #000;
            background: #f5f5f5;
        }
        #fileInputList li{
            position: relative;
        }
        .btn-remove-image {
            position: absolute;
            bottom: -20px;
            left: 0px;
            border: none;
            padding: 2px 5px;
            font-size: 12px;
            width: 100%;
        }
        @media screen and (max-width: 767px) {
            .checkmarkBox {
                top: 41px !important;
                left: 50px;
            }
        }
    </style>

@endsection
@section('content')

    @if (Session::has('stripe_client_secret'))
        <div class="alert alert-warning">Please pay to avail this promotion.</div>
        <div class="stripe-errors"></div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="all-list-bre searchbanner" style="background-image: url('{{asset('assets_frontend/img/electronices.jpg')}}');">
        <div class="container sec-all-list-bre">
            <div class="row">
                <ul>
                    <li><a href="{{url('/')}}">Back to Search</a>
                        <li><a href="{{url('dashboard/myadds')}}">Back to Ad Listing</a>
                    </li>
                    <li><span>My Adds</span>
                    </li>
                </ul>
                <h2 style="visibility: hidden;">My Profile</h2>
                <h1>{{$adv->title}}</h1>
            </div>
        </div>
    </section>



    <section class="post-text">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-5">

                    @if(Session::has('stripe_client_secret')) @else
                    <form action="{{ route('updateStore') }}" method="POST" enctype="multipart/form-data" id="updatePostForm">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$adv->id}}" name="id">
                    @endif
                            <div class="postForm">

                                <input type="hidden" name="category[]" value="{{ $adv->category_id }}">

                                <div class="category_field_html">
                                    @include('frontend.includes.category_fields', ['category' => $adv->category, 'adv' => $adv->fields->pluck('value', 'name')->toArray()])
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Ad Title</label>
                                        <span>(Required)</span>
                                    </div>
                                    <span class="charCount"><span>0</span>/100</span>
                                    <input type="text" name="name" class="form-control charCounting" data-char="100"
                                        placeholder="Type your add title" required value="{{$adv->title}}">
                                    <small>Use keywords describing your item, like model, make, type, age, etc.</small>
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Location</label>
                                        <span>(Required)</span>
                                    </div>
                                    <input type="hidden" name="country" value="198">
                                    {{-- <select class="form-control fetchStates" name="country" data-location="state" required>
                                        <option value="">Select your country</option>
                                        @foreach (getCountries() as $c => $country)
                                            <option value="{{ $country }}" @if(isset($adv->country) && $adv->country == $c) selected @endif>{{ $c }}</option>
                                        @endforeach
                                    </select> --}}
                                    <div class="states-box">
                                        {{-- @if(isset($adv->country)) --}}
                                        <select name="state" class="form-control fetchStates stateSelect" data-location="city" required="">
                                            @foreach(getStatesByCountryName('Botswana') as $state)
                                            <option value="{{ $state->id }}" @if(isset($adv->state) && $adv->state == $state->name) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- @endif --}}
                                    </div>
                                    <div class="cities-box">
                                        @if(isset($adv->state))
                                        <select name="city" class="form-control citySelect" required="">
                                            @foreach(getCitiesByStateName($adv->state, $adv->country) as $city)
                                            <option value="{{ $city->id }}" @if(isset($adv->city) && $adv->city == $city->name) selected @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Description</label>
                                        <span>(Required)</span>
                                    </div>
                                    <span class="charCount"><span>0</span>/500</span>
                                    <textarea rows="4" cols="50" class="form-control charCounting" data-char="500" name="description"
                                        placeholder="Type a detailed desciption here..." required>{{$adv->description}}</textarea>
                                    <small>A detailed description of your item will increase your chances of selling.</small>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="labelTxt">
                                            <label>Payment Type</label>
                                            <span>(Required)</span>
                                        </div>
                                        <select class="form-control paymentType" name="payment_type">
                                            <option value="free" {{($adv->payment_type == 'free')?'selected':''}}>Free</option>
                                            <option value="amount" {{($adv->payment_type == 'amount')?'selected':''}}>Amount</option>
                                            <option value="negotiable" {{($adv->payment_type == 'negotiable')?'selected':''}}>Negotiable</option>
                                            <option value="contact" {{($adv->payment_type == 'contact')?'selected':''}}>Contact For Price</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="labelTxt">
                                                <label>Price</label>
                                                <span>(Required)</span>
                                            </div>
                                            <div class="currency_input">
                                                <div class="currency_s"> {{ baseSymbol() }} </div>
                                                <input type="number" name="price" class="form-control" {{($adv->payment_type != 'amount' && $adv->payment_type != 'negotiable')?'disabled':''}} value="{{$adv->price}}" placeholder="Your Selling Price" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Phone</label>
                                        <span>(Required)</span>
                                    </div>
                                    <span class="charCount"><span>0</span>/13</span>
                                    <input type="text" name="phone" class="form-control charCounting" data-char="13" placeholder="Your Phone No" value="{{$adv->phone}}" />
                                    <small>A detailed description of your item will increase your chances of selling.</small>
                                </div> --}}

                                <div class="form-group">
                                    <div class="labelTxt">
                                        <label>Pictures</label>
                                        <span>(Required)</span>
                                    </div>
                                    <div class="img_validation">
                                        <ul>
                                            <li>* Image extension must be jpg, jpeg, webp or png</li>
                                            <li>* Image size must be lower then 5mb</li>
                                        </ul>
                                    </div>
                                    <div id="fileInputDragBox" class="drag-drop-box pt-4">
                                        <div class="drag-box-content">
                                            <p>Drag & Drop your images here or click to upload</p>
                                    
                                            <input id="file-input-1" type="file" name="images[]" multiple hidden accept="image/*" />
                                        </div>
                                    </div>
                                    
                                    <ul class="filtype pt-3" id="fileInputList">
                                    
                                        {{-- EXISTING IMAGES --}}
                                        @foreach($adv->gallery as $img)
                                            <li class="fg_file existing-image" data-id="{{ $img->id }}">
                                                <img src="{{ asset('uploads/post/'.$img->image) }}" class="defaultimg" />
                                    
                                                <button type="button"
                                                    class="btn-remove-existing btn-danger"
                                                    data-id="{{ $img->id }}">
                                                    Remove
                                                </button>
                                            </li>
                                        @endforeach
                                    
                                    </ul>
                                    
                                    {{-- Hidden field to track deleted images --}}
                                    <input type="hidden" name="deleted_images" id="deleted_images">                                

                                </div>

                                @if(!Session::has('stripe_client_secret'))                                

                                <div class="form-group">
                                    <label>Promote my add</label>
                                    @foreach (allPromotes() as $promo)
                                        @php
                                            $adv_promo = $adv->promotions->where('promotion_id', $promo->id)
                                                ->where('expire', 0)->where('paid', 1)->first();
                                            if($adv_promo!=null){
                                                $diff = dateDiff($adv_promo->start_date, $adv_promo->end_date);
                                            }else{$diff=0;}
                                            $has_p = collect($promo->promote)->where('days', $diff)->count();
                                        @endphp
                                        <div class="addDd">
                                            <h3 style="display:flex;justify-content:space-between;">
                                                <div> {{ $promo['name'] }} </div>
                                                @if($adv_promo != null)
                                                    @if($adv_promo != null && $adv_promo->paid==1)
                                                        <div style="font-size:12px;color:#1eaf38;">
                                                            @if($adv_promo != null){{ dateDiff(date('Y-m-d'), $adv_promo->end_date) }} Days left @endif
                                                        </div>
                                                    @else
                                                        <div style="font-size:12px;color:#af1e1e;">
                                                            @if($adv_promo != null){{ dateDiff($adv_promo->start_date, $adv_promo->end_date) }} Days | Not paid @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            </h3>
                                            <p>{!! $promo['description'] !!}</p>
                                            <div class="lavelsDiv check_ticks">
                                                @if (isset($promo->promote) && count($promo->promote) > 0)
                                                    @foreach ($promo->promote as $pro)
                                                        <label class="containerbtn check_add @if($diff == $pro['days']) activeDays @endif @if($has_p==0) addPromo @endif"
                                                            data-promo_id="{{ $promo->id }}"
                                                            data-price="{{ $pro['price'] }}"
                                                            data-days="{{ $pro['days'] }}">
                                                            <small>{{ $pro['days'] }} Days</small>
                                                            <strong>{{ baseSymbol() }}{{ $pro['price'] }}</strong>
                                                            <span class="checkmarkBox"><em>Add</em><b
                                                                    class="fachek">&#10003;</b></span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- Payment Summary Section (shows when promotions selected) --}}
                                <div class="promotion-summary" id="promotionSummary" style="display: none; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #ddd;">
                                    <h4 style="font-size: 16px; margin-bottom: 10px;">Payment Summary</h4>
                                    <table style="width: 100%; font-size: 14px;">
                                        <tr>
                                            <td>Promotion Cost:</td>
                                            <td style="text-align: right;"><strong id="totalPromoCost">{{ baseSymbol() }} 0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Wallet Balance:</td>
                                            <td style="text-align: right;">
                                                <span id="walletBalanceDisplay">{{ baseSymbol() }} {{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span>
                                                <a href="{{ route('dashboard.wallet') }}" class="btn btn-outline-success btn-sm" style="margin-left: 10px;">Add Money</a>
                                            </td>
                                        </tr>
                                        <tr style="border-top: 1px solid #ddd;">
                                            <td><strong>Amount to Pay:</strong></td>
                                            <td style="text-align: right;"><strong id="amountToPay">{{ baseSymbol() }} 0</strong></td>
                                        </tr>
                                    </table>
                                    <p id="paymentMethodText" style="margin-top: 10px; font-size: 12px; color: #666;"></p>
                                </div>  

                                    <div class="form-group text-center mt-4">
                                        <div class="activePromo"></div>
                                        <button type="button" class="postbtn" id="updatePostBtn">Update Post</button>
                                        <p style="margin-top: 20px;font-size: 12px;width: 80%;margin-left: 10%;">
                                            By clicking on Update Post, you accept the <a href="{{url('terms-of-use')}}">Terms of Use</a>, confirm that you will abide by the Safety Tips, and declare that this posting does not include any Prohibited Items.
                                        </p>
                                    </div>
                                </div>                                                          
                                @endif

                            </div>
                    @if(Session::has('stripe_client_secret')) @else
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <div id="promotionPaymentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content" style="border-radius: 20px; padding: 5px; border: 2px solid #38a745;">
                <div class="modal-header">
                    <h4 class="modal-title text-success">Confirm Promotion Purchase</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- Payment Summary --}}
                    <div id="promotion-payment-summary">
                        <table class="table table-bordered">
                            <tr>
                                <td>Total Promotion Cost:</td>
                                <td>{{ baseSymbol() }} <span id="modal-promo-cost"></span></td>
                            </tr>
                            <tr>
                                <td>Wallet Balance:</td>
                                <td>{{ baseSymbol() }} <span id="modal-wallet-balance">{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</span></td>
                            </tr>
                            <tr>
                                <td>Amount to Pay (Card):</td>
                                <td>{{ baseSymbol() }} <span id="modal-card-amount"></span></td>
                            </tr>
                        </table>
                        <div class="text-center">
                            <button type="button" class="btn btn-success mt-3" id="confirmPromotionBtn">
                                Confirm & Update Post
                            </button>
                            <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                    {{-- Stripe Card Payment Form --}}
                    <div id="stripe-payment-form" style="display: none;">
                        <p class="text-center mb-3">
                            <strong>Enter your card details to complete payment</strong>
                        </p>
                        
                        <form id="payment-form-modal">
                            <div class="form-group">
                                <label for="card-element-modal">Card Information</label>
                                <div id="card-element-modal" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px; background: white;">
                                    <!-- Stripe card element will be inserted here -->
                                </div>
                                <div id="card-errors-modal" role="alert" style="color: #fa755a; margin-top: 5px; font-size: 14px;"></div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <button type="button" id="pay-now-btn-modal" class="btn btn-success">
                                    Pay Now
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="$('#stripe-payment-form').slideUp(); $('#promotion-payment-summary').slideDown(); $('#confirmPromotionBtn').prop('disabled', false).text('Confirm & Update Post');">
                                    Back
                                </button>
                            </div>
                        </form>
                        
                        <p class="text-center mt-3" style="font-size: 12px; color: #666;">
                            <i class="fa fa-lock"></i> Your payment is secure and encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customScripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Wallet + Stripe Payment for Edit Post Promotions
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        let elements, card, clientSecret;
        
        var walletBalance = parseFloat('{{ auth()->user()->wallet->balance ?? 0 }}');
        var baseSymbol = '{{ baseSymbol() }}';
        var currency_code = '{{getCurrency()["symbol"]}}';
        var totalPromoPrice = 0;
        var formSubmitting = false;

        // SINGLE calcPromoPrice function with wallet logic
        function calcPromoPrice() {
            var price = 0;
            var inputs = '';
            $('.activePromo').html('');
            
            $('.activeDays').each(function(k, v) {
                var p = parseFloat($(v).attr('data-price'));
                var id = $(v).attr('data-promo_id');
                var days = $(v).attr('data-days');
                inputs += '<input type="hidden" name="promo[' + k + '][id]" value="' + id + '">';
                inputs += '<input type="hidden" name="promo[' + k + '][days]" value="' + days + '">';
                inputs += '<input type="hidden" name="promo[' + k + '][price]" value="' + p + '">';
                price += p;
            });
            
            totalPromoPrice = price;
            
            if (price === 0) {
                $('#updatePostBtn').html('Update Post');
                $('#promotionSummary').slideUp();
            } else {
                updatePaymentSummary(price);
                $('#updatePostBtn').html('Update Post (' + currency_code + ' ' + number_format(price, 2) + ')');
                $('#promotionSummary').slideDown();
                $('.activePromo').html(inputs);
            }
            
            return price;
        }

        function updatePaymentSummary(totalCost) {
            var deductAmount = Math.min(walletBalance, totalCost);
            var payableAmount = Math.max(totalCost - walletBalance, 0);
            
            $('#totalPromoCost').text(baseSymbol + ' ' + number_format(totalCost, 2));
            $('#amountToPay').text(baseSymbol + ' ' + number_format(payableAmount, 2));
            
            var paymentText = '';
            if (walletBalance >= totalCost) {
                paymentText = 'Full payment will be deducted from your wallet.';
            } else if (walletBalance > 0) {
                paymentText = baseSymbol + ' ' + number_format(deductAmount, 2) + ' will be deducted from wallet. ' + 
                            baseSymbol + ' ' + number_format(payableAmount, 2) + ' will be charged to your card.';
            } else {
                paymentText = 'Full payment will be charged to your card.';
            }
            
            $('#paymentMethodText').text(paymentText);
        }

        function showPromotionPaymentModal() {
            var deductAmount = Math.min(walletBalance, totalPromoPrice);
            var payableAmount = Math.max(totalPromoPrice - walletBalance, 0);
            
            $('#modal-promo-cost').text(number_format(totalPromoPrice, 2));
            $('#modal-wallet-balance').text(number_format(walletBalance, 2));
            $('#modal-card-amount').text(number_format(payableAmount, 2));
            
            var btnText = '';
            if (walletBalance >= totalPromoPrice) {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(totalPromoPrice, 2) + ' from Wallet';
            } else if (walletBalance > 0) {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(deductAmount, 2) + ' (Wallet) + ' + 
                        baseSymbol + ' ' + number_format(payableAmount, 2) + ' (Card)';
            } else {
                btnText = 'Pay ' + baseSymbol + ' ' + number_format(totalPromoPrice, 2) + ' (Card)';
            }
            
            $('#confirmPromotionBtn').text(btnText).prop('disabled', false);
            
            // Reset modal state
            $('#promotion-payment-summary').show();
            $('#stripe-payment-form').hide();
            if (card) {
                card.clear();
            }
            
            $('#promotionPaymentModal').modal('show');
        }

        function createPaymentIntent(amount) {
            $.ajax({
                url: '{{ route("createPromotionIntent") }}',
                type: 'POST',
                data: {
                    amount: amount,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                        $('#confirmPromotionBtn').prop('disabled', false).text('Try Again');
                        formSubmitting = false;
                        return;
                    }
                    
                    clientSecret = response.clientSecret;
                    
                    // Hide summary, show Stripe card form
                    $('#promotion-payment-summary').slideUp();
                    $('#stripe-payment-form').slideDown();
                    
                    // Initialize Stripe elements only once
                    if (!elements) {
                        elements = stripe.elements();
                        card = elements.create('card', { 
                            hidePostalCode: true,
                            style: {
                                base: {
                                    fontSize: '16px',
                                    color: '#32325d',
                                    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                                    '::placeholder': {
                                        color: '#aab7c4'
                                    }
                                },
                                invalid: {
                                    color: '#fa755a',
                                    iconColor: '#fa755a'
                                }
                            }
                        });
                        card.mount('#card-element-modal');
                        
                        // Handle real-time validation errors
                        card.on('change', function(event) {
                            var displayError = document.getElementById('card-errors-modal');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                        });
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to initialize payment.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    Swal.fire('Error', errorMsg, 'error');
                    $('#confirmPromotionBtn').prop('disabled', false).text('Try Again');
                    formSubmitting = false;
                }
            });
        }

        function number_format(number, decimals) {
            return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Handle promotion selection - FIXED SELECTOR
        $('.check_ticks .containerbtn').on('click', function () {
            if ($(this).hasClass('activeDays')) {
                // Unselect if clicked again
                $(this).removeClass('activeDays');
            } else {
                // Remove selection from ALL promotions
                $('.check_ticks .containerbtn').removeClass('activeDays');

                // Select the clicked one
                $(this).addClass('activeDays');
            }

            calcPromoPrice();
        });

        // Handle update post button click
        $(document).on('click', '#updatePostBtn', function(e) {
            e.preventDefault();
            
            if (formSubmitting) {
                return;
            }
            
            // If no promotions selected, submit directly
            if (totalPromoPrice === 0) {
                formSubmitting = true;
                $('#updatePostForm').submit();
                return;
            }
            
            // Show payment confirmation modal
            showPromotionPaymentModal();
        });

        // Modal confirm button - handles payment flow
        $(document).on('click', '#confirmPromotionBtn', function(e) {
            e.preventDefault();
            
            if (formSubmitting) {
                return;
            }
            
            var payableAmount = Math.max(totalPromoPrice - walletBalance, 0);
            
            $(this).prop('disabled', true).text('Processing...');
            
            // If full wallet payment (no Stripe needed)
            if (payableAmount === 0) {
                formSubmitting = true;
                $('#updatePostForm').submit();
                return;
            }
            
            // Need Stripe payment - create payment intent
            createPaymentIntent(payableAmount);
        });

        // Handle Stripe card payment
        $(document).on('click', '#pay-now-btn-modal', function(e) {
            e.preventDefault();
            
            if (formSubmitting) {
                return;
            }
            
            $(this).prop('disabled', true).text('Processing Payment...');
            
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error
                    Swal.fire('Payment Failed', result.error.message, 'error');
                    $('#pay-now-btn-modal').prop('disabled', false).text('Pay Now');
                    formSubmitting = false;
                } else if (result.paymentIntent.status === 'succeeded') {
                    // Payment successful - add payment intent to form and submit
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'payment_intent',
                        value: result.paymentIntent.id
                    }).appendTo('#updatePostForm');
                    
                    formSubmitting = true;
                    $('#updatePostForm').submit();
                }
            });
        });

        // Modal close - reset state
        $('#promotionPaymentModal').on('hidden.bs.modal', function () {
            $('#promotion-payment-summary').show();
            $('#stripe-payment-form').hide();
            $('#confirmPromotionBtn').prop('disabled', false).text('Confirm & Update Post');
            $('#pay-now-btn-modal').prop('disabled', false).text('Pay Now');
            if (card) {
                card.clear();
            }
            formSubmitting = false;
        });

        // ALL YOUR EXISTING CODE BELOW
        $(document).on('change', '.fetchStates', function() {
            var id = $(this).val();
            var location = $(this).attr('data-location');
            if(location === 'state'){
                var url = '{!! url("get-states") !!}/'+id;
            }else{
                var url = '{!! url("get-cities") !!}/'+id;
            }
            var data = {
                id: id
            };
            if (id != null && id != '') {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    success: function(res) {
                        var html = `<option value="" selected disabled style="display:none">Select a ${location}</option>`;
                        if (location == 'state') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}">${value}</option>`;
                            });
                            $('.stateSelect').html(html);
                        } else if (location == 'city') {
                            $.each(res, function(index, value) {
                                html += `<option value="${index}">${value}</option>`;
                            });
                            $('.citySelect').html(html);
                        }
                    }
                })
            } else {
                var html = `<option value="" selected disabled>Select</option>`;
                if (location == 'state') {
                    $('.stateSelect').html(html);
                    $('.citySelect').html(html);
                } else if (location == 'city') {
                    $('.citySelect').html(html);
                }
            }
        });

        $('.select_2').select2();

        setTimeout(() => {
            $('.alert-success').fadeOut(300);
            $('.alert-danger').fadeOut(300);
            $('.alert-warning').fadeOut(300);
        }, 3000);

        $(document).on('change', '.fetchMakeModels', function() {
            var id = $(this).find('option:selected').attr('data-id');
            var data = {
                _token: '{{ csrf_token() }}',
                id: id
            };
            if (id != null && id != '') {
                $.ajax({
                    url: '{{ route('fetchMakeModels') }}',
                    type: 'POST',
                    data: data,
                    success: function(res) {
                        $('.makeModels').html(res.models);
                    }
                })
            } else {
                $('.makeModels').html('');
            }
        });

        $(document).on('change', '.paymentType', function() {
            var val = $(this).val();
            if (val == 'amount' || val == 'negotiable') {
                $('[name="price"]').removeAttr('disabled');
            } else {
                $('[name="price"]').attr('disabled', 'disabled');
            }
        });

        // $(document).on('change', '.pickImage', function(e) {
        //     console.log('ok');
        //     var img = $(this).val();
        //     if (img == null || img == '') {
        //         $(this).parents('.fg_file').css('border', '1px dashed #9d9d9d');
        //         $(this).parents('.fg_file').find('img').attr('src',
        //             '{{ asset('assets_frontend/img/cameras.png') }}');
        //         return false;
        //     }
        //     var ext = img.split(".").pop();
        //     var size = Math.round(($(this)[0].files[0].size / 1024));

        //     var all_clear = 1;
        //     if (['jpg', 'jpeg', 'webp', 'png'].includes(ext)) {} else {
        //         all_clear = 0;
        //     }
        //     if (size <= 5120) {} else {
        //         all_clear = 0;
        //     }

        //     if (all_clear == 1) {
        //         $(this).parents('.fg_file').css('border', 'dashed 2px green');
        //     } else {
        //         $(this).parents('.fg_file').css('border', 'dashed 2px red');
        //     }
        // });

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 250) {
                $(".hom-top").addClass("dmact");
            } else {
                $(".hom-top").removeClass("dmact");
            }
        });

        $(".pmenu-spri ul li").mouseenter(function() {
            $('.pmenu-cat ul').removeClass('activeul').addClass('hideul');
            name = $(this).attr('data-name');
            $('#' + name).removeClass('hideul').addClass('activeul');
        }).mouseleave(function() {
            //
        });

        // REMOVED DUPLICATE calcPromoPrice() FUNCTION
        // REMOVED DUPLICATE CLICK HANDLER

        @if(Session::has('stripe_client_secret'))
            // OLD STRIPE CODE FOR SESSION-BASED FLOW (if you still need it)
            $('html, body').animate({ scrollTop: $('#payment-form').offset().top }, 500);

            var oldStripe = Stripe('pk_test_M5V0RLMGo2HdzzlOWwrAdD8t00hIziNTPy');
            var oldElements = oldStripe.elements();
            var style = {
                base: {
                    color: "#32325d",
                    fontSize: "13px",
                    "::placeholder": {
                        color: "#aab7c4"
                    }
                },
                invalid: {
                    color: "#fa755a",
                    iconColor: "#fa755a"
                }
            };
            var oldCard = oldElements.create("card", { style: style,iconStyle:'solid' });

            oldCard.mount("#card-element");
            stripeSecret = '{{Session::get('stripe_client_secret')}}';

            oldCard.on('change', ({error}) => {
                const displayError = document.getElementById('card-errors');
                if (error) {
                    displayError.textContent = error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(ev) {
                var submitBtn = $("#submit");
                var submitText = submitBtn.html();
                submitBtn.html('Processing Payment...');
                ev.preventDefault();
                oldStripe.confirmCardPayment(stripeSecret, {
                    payment_method: {
                        card: oldCard
                    }
                }).then(function(result) {
                    if (result.error) {
                        submitBtn.html(submitText);
                        $('.stripe-errors').append(`<div class="alert alert-danger">`+result.error.message+`</div>`);
                        $('.alert-danger').fadeOut(300);
                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            submitBtn.html('Redirecting..');
                            $.ajax({
                                url: '{{ url('dashboard/successStripeSession') }}',
                                type: 'POST',
                                data: {_token:'{{csrf_token()}}', id:result.paymentIntent.id},
                                success: function(res) {
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.cancel_promotion', function(){
                $.ajax({
                    url: '{{ url('dashboard/destroyStripeSession') }}',
                    type: 'POST',
                    data: {_token:'{{csrf_token()}}'},
                    success: function(res) {
                        location.reload();
                    }
                });
            });
        @endif
    </script>
    <script>
        let selectedFiles = [];
        let deletedImages = [];

        /* CLICK OPEN */
        $("#fileInputDragBox").on("click", function (e) {
            if ($(e.target).is("#file-input-1")) return;
            $("#file-input-1").trigger("click");
        });

        /* FILE CHANGE */
        $("#file-input-1").on("change", function (e) {
            addFiles(e.target.files);
        });

        /* DRAG */
        $("#fileInputDragBox").on("dragover", function (e) {
            e.preventDefault();
            $(this).addClass("dragging");
        });

        $("#fileInputDragBox").on("dragleave", function (e) {
            e.preventDefault();
            $(this).removeClass("dragging");
        });

        $("#fileInputDragBox").on("drop", function (e) {
            e.preventDefault();
            $(this).removeClass("dragging");
            addFiles(e.originalEvent.dataTransfer.files);
        });

        /* ADD NEW FILES */
        function addFiles(files) {

            Array.from(files).forEach(file => {
                if (!file.type.startsWith("image/")) return;
                selectedFiles.push(file);
            });

            renderAll();
        }

        /* RENDER ALL */
        function renderAll() {

            $("#fileInputList").find(".new-image").remove();

            let dt = new DataTransfer();

            selectedFiles.forEach((file, index) => {

                dt.items.add(file);

                let reader = new FileReader();

                reader.onload = function (e) {

                    $("#fileInputList").append(`
                        <li class="fg_file new-image" data-index="${index}">
                            <img src="${e.target.result}" class="defaultimg" />

                            <button type="button" class="btn-remove-new btn-danger">
                                Remove
                            </button>
                        </li>
                    `);
                };

                reader.readAsDataURL(file);
            });

            document.getElementById("file-input-1").files = dt.files;
        }

        /* REMOVE NEW FILE */
        $(document).on("click", ".btn-remove-new", function () {

            let index = $(this).closest(".fg_file").data("index");

            selectedFiles.splice(index, 1);

            renderAll();
        });

        /* REMOVE EXISTING IMAGE */
        $(document).on("click", ".btn-remove-existing", function () {

            let id = $(this).data("id");

            deletedImages.push(id);

            $("#deleted_images").val(JSON.stringify(deletedImages));

            $(this).closest(".fg_file").remove();
        });
    </script>
@endsection
