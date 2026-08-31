@extends('layouts.frontend')

@section('title', 'Post Your Ads' . ' | Batswana Goo')

@push('push_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets_frontend/css/ad-post.css') }}?v=1.2">
<style>
    .addDd {
        position: relative;
    }
    .checkmarkBox {
        position: absolute;
        background: #1eaf38;
        width: 50px;
        height: 34px;
        border-radius: 10px;
        left: auto;
        top: 130px;
    }
    .charCount {
        bottom: 1px;
    }
    .drag-box-content {
        border: 2px dashed #3a6ebf;
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

    /* Category modal */
    #categoryModalTrigger {
        background: #fff;
    }
    .category-modal .modal-content {
        border-radius: 20px;
        overflow: hidden;
        border: none;
        padding: 0;
    }
    .category-modal-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 20px 12px 20px;
    }
    .cat-modal-back {
        border: none;
        background: transparent;
        font-size: 18px;
        color: #333;
        padding: 0;
        line-height: 1;
    }
    /* Border-drawn chevrons - no icon font dependency */
    .cat-chevron {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-right: 2px solid currentColor;
        border-bottom: 2px solid currentColor;
        vertical-align: middle;
    }
    .cat-chevron-left {
        transform: rotate(135deg);
        margin-left: 2px;
    }
    .cat-chevron-right {
        transform: rotate(-45deg);
        margin-right: 2px;
    }
    .cat-modal-title {
        flex: 1;
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #222;
    }
    .cat-modal-close {
        border: none;
        background: transparent;
        font-size: 22px;
        color: #888;
        line-height: 1;
        padding: 0;
    }
    .category-modal-body {
        padding: 0 20px 20px 20px;
    }
    .cat-modal-search-wrap {
        position: relative;
        margin-bottom: 10px;
    }
    .cat-modal-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        opacity: 0.6;
    }
    .cat-modal-search {
        border-radius: 30px;
        padding: 10px 16px 10px 38px;
        border: 1px solid #e5e5e5;
        box-shadow: none;
    }
    .cat-modal-breadcrumb {
        font-size: 14px;
        padding: 10px 4px;
        border-bottom: 1px solid #eee;
        margin-bottom: 4px;
        color: #99a3b0;
    }
    .cat-modal-breadcrumb a {
        color: #1eaf38;
    }
    .cat-modal-breadcrumb strong {
        color: #222;
    }
    .cat-modal-breadcrumb .cat-chevron {
        width: 6px;
        height: 6px;
        margin: 0 4px;
    }
    .cat-modal-list-wrap {
        max-height: 55vh;
        overflow-y: auto;
    }
    .cat-modal-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .cat-modal-item, .cat-search-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 12px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        border-radius: 10px;
    }
    .cat-modal-item:hover, .cat-search-item:hover {
        background: #f8f9fa;
    }
    .cat-modal-item.selected, .cat-search-item.selected {
        background: #eafbee;
        color: #1eaf38;
        font-weight: 600;
    }
    .cat-item-arrow, .cat-item-check {
        color: #99a3b0;
    }
    .cat-modal-item.selected .cat-item-check, .cat-search-item.selected .cat-item-check {
        color: #1eaf38;
    }
    .cat-item-path {
        display: block;
        color: #99a3b0;
        font-size: 12px;
        font-weight: 400;
        margin-top: 2px;
    }
    .cat-modal-empty, .cat-modal-loading {
        text-align: center;
        color: #99a3b0;
        padding: 30px 0;
    }
</style>
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="postss">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <div class="sub-tit">
                        <h2>Post an Add</h2>
                        <p>You are currently using the new experience for posting an ad! We are improving our design to help you post an ad faster and easier!</p>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="whats">
        <div class="container">
            <div class="row">                
                {{-- <div class="col-md-4 col-sm-12 col-12 text-center d-none">
                    <h5>What are you posting an ad for?</h5>
                    <div id="postad-sidebar">
                        <div class="post-ad-sidebar-menu">
                            @foreach ($mainCategories as $mainCate)
                            <div class="postad-cat-item">
                                <a href="javascript:void(0);" class="sub-btn fatchCategory" data-id="{{ $mainCate->id }}" data-name="{{ $mainCate->name }}"> <i><img src="{{ $mainCate->icon_image ?? asset('placeholder.png')  }}" alt="{{ $mainCate->name }}"></i> {{ $mainCate->name }} 
                                </a>                               
                            </div>
                            @endforeach
                            <div class="postad-cat-item">
                                <a href="javascript:void(0);" class="fatchCategory" data-id="other"
                                        data-name="Other Categories"><i class=""><img src="{{ url('sdicon.png')  }}" alt="All Other Categories"></i>All Other Categories</a>
                            </div>
                        </div>
                    </div>                    
                </div> --}}
                <div class="col-md-8 col-sm-12 offset-md-2 offset-sm-0 text-center">
                    <div style="margin-bottom: 10px;">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="rightside-heading d-none">
                                    <h3 class="mb-0">You are now posting in
                                        <span class="nameCategory" style="color: #1cae38;font-weight: 600;font-style: italic;">{{ $initialCategory ? collect($initialCategory->breadcrumbs)->pluck('name')->implode(' > ') : 'Select a category' }}</span>
                                    </h3>
                                </div>
                                <form action="{{ url('add-ads') }}" method="POST" enctype="multipart/form-data" id="mainAdForm">
                                    {{ csrf_field() }}
                                    <div class="postForm">
                                        <div class="form-group">
                                            <div class="labelTxt">
                                                <label>Ad Title</label>
                                                <span class="charCount"><span>0</span>/100 (Required)</span>
                                            </div>
                                            <input type="text" name="name" class="form-control charCounting" data-char="100" placeholder="Type your add title" required value="{{ ($post->title)??'' }}" id="ad-title">
                                            <span class="error-msg" id="ad-title-error"></span>
                                            <small>Use keywords describing your item.</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="labelTxt">
                                                <label>Category</label>
                                                <span>(Required)</span>
                                            </div>
                                            <button type="button" id="categoryModalTrigger" class="form-control d-flex align-items-center justify-content-between text-start" style="cursor:pointer;">
                                                <span class="nameCategory">{{ $initialCategory ? collect($initialCategory->breadcrumbs)->pluck('name')->implode(' > ') : 'Select a category' }}</span>
                                                <img src="{{asset('assets_frontend/img/icon/down-arrow.svg')}}" style="width: 11px;flex-shrink:0;margin-left:8px;">
                                            </button>
                                            <span class="error-msg" id="category-error"></span>
                                            <small>Choose the category that best matches your listing.</small>
                                        </div>
                                        <input type="hidden" name="category[]" id="selectedCategoryId" value="{{ $initialCategory->id ?? '' }}">
                                        <div class="postFormContent">
                                            <div class="category_field_html">
                                                @if($initialCategory)
                                                    @include('frontend.includes.category_fields', [
                                                        'category' => $initialCategory,
                                                    ])
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <div class="labelTxt">
                                                    <label>Location</label>
                                                    <span>(Required)</span>
                                                </div>
                                                <input type="hidden" name="country" value="198">
                                                {{-- <select class="form-control fetchLocation autoSelectCountry" name="country" required data-location="state" style="visibility: hidden;">
                                                    <option value="" disabled selected style="display:none">Select a Country</option>
                                                    @foreach (getCountries() as $k => $country)
                                                        <option value="{{ $country }}" @if(isset($post->country) && $post->country === $k) selected @endif>{{ $k }}</option>
                                                    @endforeach
                                                </select> --}}
                                                <select class="form-control fetchLocation stateSelect" name="state" required data-location="city">
                                                    <option value="" selected disabled>Select a State</option>
                                                    @foreach (getStatesByCountryName('Botswana') as $k => $state)
                                                        <option value="{{ $state->id }}" @if(isset($post->state) && $post->state === $state->name) selected @endif>{{ $state->name }}</option>
                                                    @endforeach
                                                    {{-- @if(isset($post->country))
                                                        @foreach (getStatesByCountryName($post->country) as $k => $state)
                                                            <option value="{{ $state->id }}" @if(isset($post->state) && $post->state === $state->name) selected @endif>{{ $state->name }}</option>
                                                        @endforeach
                                                    @endif --}}
                                                </select>
                                                <select class="form-control mt-2 citySelect" name="city" required>
                                                    <option value="" selected disabled>Select a City</option>
                                                    @if(isset($post->country) && isset($post->state))
                                                        @foreach (getCitiesByStateName($post->state, $post->country) as $k => $city)
                                                            <option value="{{ $city->id }}" @if(isset($post->city) && $post->city === $city->name) selected @endif>{{ $city->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
            
                                            <div class="form-group">
                                                <div class="labelTxt">
                                                    <label>Description</label>
                                                    <em><span class="charCount"><span>0</span>/500</span><span>(Required) </span></em>
                                                </div>
                                                <textarea rows="4" cols="50" name="description" class="form-control charCounting" data-char="500" placeholder="Type a detailed desciption here..." required></textarea>
                                                <small>A detailed description of your item will increase your chances of selling.</small>
                                            </div>
            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="labelTxt">
                                                        <label>Payment Type</label>
                                                        <span>(Required)</span>
                                                    </div>
                                                    <select class="form-control paymentType" name="payment_type">
                                                        <option value="free">Free</option>
                                                        <option value="amount">Amount</option>
                                                        <option value="negotiable">Negotiable</option>
                                                        <option value="contact">Contact For Price</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="labelTxt">
                                                            <label>Price</label>
                                                            <span>(Required)</span>
                                                        </div>
                                                        <!--<span class="charCount"><span>0</span>/15</span>-->
                                                        <div class="currency_input">
                                                            <div class="currency_s"> {{ baseSymbol() }} </div>
                                                            <input type="number" name="price"
                                                                class="form-control" disabled
                                                                placeholder="Your Selling Price" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            
                                            {{-- <div class="form-group">
                                                <div class="labelTxt">
                                                    <label>Phone</label>
                                                    <span class="charCount"><span>0</span>/13 Required</span>
                                                </div>
                                                <input type="tel" class="form-control charCounting" data-char="13" placeholder="Type Your Phone No" name="phone" value="{{ old('phone') ?? auth()->user()->phone }}" required />
                                            </div> --}}
            
                                            <div class="form-group">
                                                <div class="labelTxt">
                                                    <label>Pictures</label>
                                                    <span>(Minimum 3 Required)</span>
                                                </div>
                                                <div class="img_validation">
                                                    <ul>
                                                        <li><small>* At least 3 images are required</small></li>
                                                        <li><small>* Image extension must be jpg, jpeg, webp or png</small></li>
                                                        <li><small>* Image size must be lower then 5mb</small></li>
                                                    </ul>
                                                </div>
                                                <div id="fileInputDragBox" class="drag-drop-box pt-4">
                                                    <div class="drag-box-content">
                                                        <p>Drag & Drop your images here or click to upload</p>
                                                
                                                        <input id="file-input-1" type="file" name="images[]" multiple hidden accept="image/*" />
                                                    </div>
                                                </div>
                                                
                                                <ul class="filtype pt-3" id="fileInputList">
                                                    {{-- <li class="fg_file">
                                                        <label class="file-input" for="file-input-1">
                                                            <img src="{{ asset('assets_frontend/img/cameras.png') }}"
                                                                class="defaultimg" />
                                                            <input id="file-input-1" class="pickImage"
                                                                name="images[]" type="file" />
                                                        </label>
                                                        <button type="button" class="btn-remove-image btn-danger">remove</button>
                                                    </li> --}}                                                    
                                                </ul>
                                            </div>
            
                                            <div class="form-group">
                                                {{-- <h4 class="text-center">Promote my add</h4>
                                                @if(isset($promotes))
                                                    @foreach ($promotes as $promo)
                                                        <div class="addDd">
                                                            <h3>{{ $promo['name'] }}</h3>
                                                            <p>{!! $promo['description'] !!}</p>
                                                            <div class="lavelsDiv check_ticks">
                                                                @if (isset($promo->promote) && count($promo->promote) > 0)
                                                                    @foreach ($promo->promote as $pro)
                                                                        <label class="containerbtn check_add"
                                                                            data-promo_id="{{ $promo->id }}"
                                                                            data-price="{{ $pro['price'] }}"
                                                                            data-days="{{ $pro['days'] }}">
                                                                            <small>{{ $pro['days'] }} Days</small>
                                                                            <strong>{{ baseSymbol() }} {{ $pro['price'] }}</strong>
                                                                            <span class="checkmarkBox"><em>Add</em><b
                                                                                    class="fachek">&#10003;</b></span>
                                                                        </label>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                            
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
                                                @endif --}}
                                                <div class="form-group text-center mt-4">
                                                    <div class="activePromo"></div>
                                                    <button type="button" class="postbtn" id="submitAdBtn">Submit Ad</button>
                                                                
                                                    <p style="margin-top: 20px;font-size: 12px;width: 80%;margin-left: 10%; ">
                                                        By clicking on Post Ad, you accept the <a href="{{ url('terms-of-use') }}">Terms of Use</a>, confirm that you will
                                                        abide by the Safety Tips, and declare that this posting does not include any
                                                        Prohibited Items.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="categoryModal" class="modal fade category-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="category-modal-header">
                    <button type="button" class="cat-modal-back" style="display:none;" aria-label="Back">
                        <span class="cat-chevron cat-chevron-left"></span>
                    </button>
                    <h4 class="cat-modal-title">Choose a category</h4>
                    <button type="button" class="cat-modal-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="category-modal-body">
                    <div class="cat-modal-search-wrap">
                        <img src="{{asset('assets_frontend/img/icon/search.png')}}" class="cat-modal-search-icon" alt="Search">
                        <input type="text" class="form-control cat-modal-search" placeholder="Search categories...">
                    </div>
                    <div class="cat-modal-breadcrumb" style="display:none;"></div>
                    <div class="cat-modal-list-wrap">
                        <ul class="cat-modal-list"></ul>
                        <div class="cat-modal-empty" style="display:none;">No categories found.</div>
                        <div class="cat-modal-loading" style="display:none;">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="promotionPaymentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content" style="border-radius: 20px; padding: 5px; border: 2px solid #38a745;">
                <div class="modal-header">
                    <h4 class="modal-title text-success">Confirm Promotion Purchase</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
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
                                Confirm & Post Ad
                            </button>
                            <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
    
                    <div id="stripe-payment-form" style="display: none;">
                        <p class="text-center mb-3">
                            <strong>Enter your card details to complete payment</strong>
                        </p>
                        
                        <form id="payment-form">
                            <div class="form-group">
                                <label for="card-element">Card Information</label>
                                <div id="card-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px; background: white;">
                                </div>
                                <div id="card-errors" role="alert" style="color: #fa755a; margin-top: 5px; font-size: 14px;"></div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-secondary" onclick="$('#stripe-payment-form').slideUp(); $('#promotion-payment-summary').slideDown(); $('#confirmPromotionBtn').prop('disabled', false).text('Confirm & Post Ad');">
                                    Back
                                </button>
                                <button type="button" id="pay-now-btn" class="btn btn-success">
                                    Pay Now
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
    </div> --}}
@endsection

@section('customScripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    let elements, card, clientSecret;
    
    var walletBalance = parseFloat('{{ auth()->user()->wallet->balance ?? 0 }}');
    var baseSymbol = '{{ baseSymbol() }}';
    var totalPromoPrice = 0;
    var formSubmitting = false;

    $(document).on('keyup', '.charCounting', function() {
        var len = $(this).val().length;
        var limit = $(this).attr('data-char');
        if (len > limit) {
            $(this).val($(this).val().substring(0, limit));
        } else {
            $(this).parent().find('.charCount').find('span').text($(this).val().length);
        }
    });

    $(document).ready(function(){
        $('.select_2').select2();
        $('.postad-cat-item .sub-btn').click(function(){
            $(this).next('.postad-cat-sub-menu').slideToggle();
            $(this).find('.postad-cat-sub-menu .dropdown').toggleClass('rotate');
        });

        // Handle promotion selection
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

        // Handle submit button click
        $('#submitAdBtn').on('click', function(e) {
            e.preventDefault();
            
            if (formSubmitting) {
                return;
            }

            // A category must be selected
            if (!$('#selectedCategoryId').val()) {
                Swal.fire('Error', 'Please select a category', 'error');
                return;
            }

            // At least 3 images are required
            if (selectedFiles.length < 3) {
                Swal.fire('Error', 'Please upload at least 3 images', 'error');
                return;
            }

            // Validate form first
            var isValid = validateAdForm();
            if (!isValid) {
                Swal.fire('Error', 'Please fill in all required fields', 'error');
                return;
            }
            
            // If no promotions selected, submit directly
            if (totalPromoPrice === 0) {
                formSubmitting = true;
                $('#mainAdForm').submit();
                return;
            }
            
            // Show payment confirmation modal
            showPromotionPaymentModal();
        });
        
        // Modal confirm button - handles payment flow
        $('#confirmPromotionBtn').on('click', function(e) {
            e.preventDefault();
            
            if (formSubmitting) {
                return;
            }
            
            var payableAmount = Math.max(totalPromoPrice - walletBalance, 0);
            
            $(this).prop('disabled', true).text('Processing...');
            
            // If full wallet payment (no Stripe needed)
            if (payableAmount === 0) {
                formSubmitting = true;
                $('#mainAdForm').submit();
                return;
            }
            
            // Need Stripe payment - create payment intent
            createPaymentIntent(payableAmount);
        });
    });

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
                    card.mount('#card-element');
                    
                    // Handle real-time validation errors
                    card.on('change', function(event) {
                        var displayError = document.getElementById('card-errors');
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

    // Handle Stripe card payment
    $(document).on('click', '#pay-now-btn', function(e) {
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
                $('#pay-now-btn').prop('disabled', false).text('Pay Now');
                formSubmitting = false;
            } else if (result.paymentIntent.status === 'succeeded') {
                // Payment successful - add payment intent to form and submit
                $('<input>').attr({
                    type: 'hidden',
                    name: 'payment_intent',
                    value: result.paymentIntent.id
                }).appendTo('#mainAdForm');
                
                formSubmitting = true;
                $('#mainAdForm').submit();
            }
        });
    });

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
            $('#submitAdBtn').html('Submit Ad');
            $('#promotionSummary').slideUp();
        } else {
            updatePaymentSummary(price);
            $('#submitAdBtn').html('Submit Ad <span>(' + baseSymbol + ' ' + number_format(price, 2) + ') </span>');
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

    // Modal close - reset state
    $('#promotionPaymentModal').on('hidden.bs.modal', function () {
        $('#promotion-payment-summary').show();
        $('#stripe-payment-form').hide();
        $('#confirmPromotionBtn').prop('disabled', false).text('Confirm & Post Ad');
        $('#pay-now-btn').prop('disabled', false).text('Pay Now');
        if (card) {
            card.clear();
        }
        formSubmitting = false;
    });

    function validateAdForm() {
        // Check required fields
        var title = $('[name="name"]').val();
        var description = $('[name="description"]').val();
        // var phone = $('[name="phone"]').val();
        var state = $('[name="state"]').val();
        var city = $('[name="city"]').val();
        var category = $('#selectedCategoryId').val();

        if (!title || !description || !state || !city || !category) {
            return false;
        }

        return true;
    }

    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Keep all your existing JavaScript functions below
    $(document).on('focusout', '#ad-title', function() {
        var title = $(this).val();
        $('#ad-title').css('border-color', '#1eaf38');
        var data = {
            _token: '{{ csrf_token() }}',
            title: title
        };
        $.ajax({
            url: "{{ route('checkDuplicateAd') }}",
            type: 'POST',
            data: data,
            success: function(res) {
                if(res.status == 1){
                    $('#ad-title').css('border-color', 'red');
                    $('#ad-title-error').html('<span style="color: red;">' + res.message + '</span><br />');
                } else {
                    $('#ad-title').css('border-color', '#1eaf38');
                    $('#ad-title-error').html('');
                }
            }
        });
    });

    /* -------------------------
       CATEGORY MODAL
       "You are now posting in" opens a single modal that supports
       unlimited nested categories: browse in, search across every level,
       breadcrumb/back navigation, and auto-close on picking a leaf.
    --------------------------*/
    var catModalStack = []; // breadcrumb of the level currently being browsed (server-provided, always accurate)
    var catModalSearchTimer = null;

    $(document).on('click', '#categoryModalTrigger', function() {
        $('#categoryModal').modal('show');
        $('.cat-modal-search').val('');

        var selectedId = $('#selectedCategoryId').val();
        if (selectedId) {
            // Open directly at the selected category's own level, so its
            // siblings show with it checked - matches how a "current
            // selection" picker should behave. `breadcrumb` includes the
            // selected category itself as the last entry, so its parent is
            // the second-to-last one (or root, if it's a top-level category).
            $.ajax({
                url: '{{ route("categoryModal") }}',
                type: 'GET',
                data: { id: selectedId },
                success: function(res) {
                    var crumb = res.breadcrumb || [];
                    loadCategoryLevel(crumb.length > 1 ? crumb[crumb.length - 2].id : null);
                },
                error: function() {
                    loadCategoryLevel(null);
                }
            });
        } else {
            loadCategoryLevel(null);
        }
    });

    function loadCategoryLevel(parentId) {
        $('.cat-modal-loading').show();
        $('.cat-modal-list').empty();
        $('.cat-modal-empty').hide();

        $.ajax({
            url: '{{ route("categoryModal") }}',
            type: 'GET',
            data: { id: parentId },
            success: function(res) {
                $('.cat-modal-loading').hide();
                catModalStack = res.breadcrumb || [];
                renderCategoryList(res.items);
                renderBreadcrumb(catModalStack);
                $('.cat-modal-title').text(res.parent ? res.parent.name : 'Choose a category');
                $('.cat-modal-back').toggle(catModalStack.length > 0);
            }
        });
    }

    function renderBreadcrumb(breadcrumb) {
        if (!breadcrumb || breadcrumb.length === 0) {
            $('.cat-modal-breadcrumb').hide().empty();
            return;
        }
        var html = '<a href="javascript:void(0);" class="cat-crumb-root">All</a>';
        breadcrumb.forEach(function(crumb, i) {
            var isLast = i === breadcrumb.length - 1;
            html += ' <span class="cat-chevron cat-chevron-right"></span> ';
            html += isLast
                ? '<strong>' + crumb.name + '</strong>'
                : '<a href="javascript:void(0);" class="cat-crumb-link" data-id="' + crumb.id + '">' + crumb.name + '</a>';
        });
        $('.cat-modal-breadcrumb').html(html).show();
    }

    function renderCategoryList(items) {
        var selectedId = $('#selectedCategoryId').val();
        var html = '';
        if (!items || items.length === 0) {
            $('.cat-modal-empty').show();
            return;
        }
        items.forEach(function(item) {
            var isSelected = selectedId && String(selectedId) === String(item.id);
            html += '<li class="cat-modal-item' + (isSelected ? ' selected' : '') + '" data-id="' + item.id + '" data-name="' + escapeHtmlAttr(item.name) + '" data-has-children="' + (item.has_children ? 1 : 0) + '">';
            html += '<span class="cat-item-name">' + item.name + '</span>';
            if (item.has_children) {
                html += '<span class="cat-chevron cat-chevron-right cat-item-arrow"></span>';
            } else if (isSelected) {
                html += '<span class="cat-item-check">&#10003;</span>';
            }
            html += '</li>';
        });
        $('.cat-modal-list').html(html);
    }

    function escapeHtmlAttr(text) {
        return String(text).replace(/"/g, '&quot;');
    }

    $(document).on('click', '.cat-modal-item', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var hasChildren = $(this).data('has-children') == 1;

        if (hasChildren) {
            loadCategoryLevel(id);
            $('.cat-modal-search').val('');
        } else {
            var pathNames = catModalStack.map(function(c) { return c.name; });
            pathNames.push(name);
            selectCategory(id, pathNames.join(' > '));
            $('#categoryModal').modal('hide');
        }
    });

    $(document).on('click', '.cat-modal-back', function() {
        var parentId = catModalStack.length > 1 ? catModalStack[catModalStack.length - 2].id : null;
        loadCategoryLevel(parentId);
        $('.cat-modal-search').val('');
    });

    $(document).on('click', '.cat-crumb-root', function() {
        loadCategoryLevel(null);
        $('.cat-modal-search').val('');
    });

    $(document).on('click', '.cat-crumb-link', function() {
        loadCategoryLevel($(this).data('id'));
        $('.cat-modal-search').val('');
    });

    $(document).on('input', '.cat-modal-search', function() {
        var term = $(this).val().trim();
        clearTimeout(catModalSearchTimer);

        if (term === '') {
            loadCategoryLevel(catModalStack.length ? catModalStack[catModalStack.length - 1].id : null);
            return;
        }

        catModalSearchTimer = setTimeout(function() {
            searchCategories(term);
        }, 300);
    });

    function searchCategories(term) {
        $('.cat-modal-loading').show();
        $('.cat-modal-list').empty();
        $('.cat-modal-empty').hide();
        $('.cat-modal-breadcrumb').hide();
        $('.cat-modal-back').hide();
        $('.cat-modal-title').text('Search results');

        $.ajax({
            url: '{{ route("categoryModal") }}',
            type: 'GET',
            data: { search: term },
            success: function(res) {
                $('.cat-modal-loading').hide();
                renderSearchResults(res.items);
            }
        });
    }

    function renderSearchResults(items) {
        var selectedId = $('#selectedCategoryId').val();
        var html = '';
        if (!items || items.length === 0) {
            $('.cat-modal-empty').show();
            return;
        }
        items.forEach(function(item) {
            var isSelected = selectedId && String(selectedId) === String(item.id);
            html += '<li class="cat-search-item' + (isSelected ? ' selected' : '') + '" data-id="' + item.id + '" data-has-children="' + (item.has_children ? 1 : 0) + '" data-path="' + escapeHtmlAttr(item.path) + '">';
            html += '<span class="cat-item-name">' + item.name + '<small class="cat-item-path">' + item.path + '</small></span>';
            if (item.has_children) {
                html += '<span class="cat-chevron cat-chevron-right cat-item-arrow"></span>';
            } else if (isSelected) {
                html += '<span class="cat-item-check">&#10003;</span>';
            }
            html += '</li>';
        });
        $('.cat-modal-list').html(html);
    }

    // Separate class from .cat-modal-item (browse rows) so this delegated
    // handler can't double-fire alongside the browse click handler above.
    $(document).on('click', '.cat-search-item', function() {
        var id = $(this).data('id');
        var hasChildren = $(this).data('has-children') == 1;
        var path = $(this).data('path');

        if (hasChildren) {
            // Drill in - the server resolves the real breadcrumb for this id.
            $('.cat-modal-search').val('');
            loadCategoryLevel(id);
        } else {
            selectCategory(id, path);
            $('#categoryModal').modal('hide');
        }
    });

    function selectCategory(id, path) {
        $('#selectedCategoryId').val(id);
        $('.nameCategory').text(path);
        $('#category-error').text('');

        $('.category_field_html').html('<div class="fetching_fields"> Please wait, Fetching fields ... </div>');
        $.ajax({
            url: '{{ route('fetchSubCategory') }}',
            type: 'GET',
            data: { id: id, _token: '{{ csrf_token() }}' },
            success: function(res) {
                $('.category_field_html').html(res.category_fields);
                $('.select_2').select2({
                    closeOnSelect: false
                });
            }
        });
    }

    $(document).on('change', '.fetchLocation', function() {
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

    $(document).on('change', '.paymentType', function() {
        var val = $(this).val();
        if (val == 'amount' || val == 'negotiable') {
            $('[name="price"]').removeAttr('disabled');
        } else {
            $('[name="price"]').attr('disabled', 'disabled');
        }
    });

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
</script>

<script>
    let selectedFiles = [];

/* -------------------------
   CLICK TO OPEN FILE PICKER
--------------------------*/
$("#fileInputDragBox").on("click", function (e) {

    if ($(e.target).is("#file-input-1")) return;

    $("#file-input-1").trigger("click");
});

/* -------------------------
   FILE INPUT CHANGE
--------------------------*/
$("#file-input-1").on("change", function (e) {

    addFiles(e.target.files);
});

/* -------------------------
   DRAG OVER
--------------------------*/
$("#fileInputDragBox").on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass("dragging");
});

/* -------------------------
   DRAG LEAVE
--------------------------*/
$("#fileInputDragBox").on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragging");
});

/* -------------------------
   DROP FILES
--------------------------*/
$("#fileInputDragBox").on("drop", function (e) {

    e.preventDefault();
    e.stopPropagation();

    $(this).removeClass("dragging");

    addFiles(e.originalEvent.dataTransfer.files);
});

/* -------------------------
   ADD FILES FUNCTION
--------------------------*/
function addFiles(files) {

    Array.from(files).forEach(file => {

        if (!file.type.startsWith("image/")) return;

        selectedFiles.push(file);
    });

    renderFiles();
}

/* -------------------------
   RENDER PREVIEW + INPUT SYNC
--------------------------*/
function renderFiles() {

    $("#fileInputList").html("");

    let dataTransfer = new DataTransfer();

    selectedFiles.forEach((file, index) => {

        dataTransfer.items.add(file);

        let reader = new FileReader();

        reader.onload = function (e) {

            let html = `
                <li class="fg_file" data-index="${index}">
                    <img src="${e.target.result}" class="defaultimg" />

                    <button type="button" class="btn-remove-image btn-danger">
                        Remove
                    </button>
                </li>
            `;

            $("#fileInputList").append(html);
        };

        reader.readAsDataURL(file);
    });

    // update real input files (IMPORTANT for Laravel)
    document.getElementById("file-input-1").files = dataTransfer.files;
}

/* -------------------------
   REMOVE IMAGE
--------------------------*/
$(document).on("click", ".btn-remove-image", function () {

    let index = $(this).closest(".fg_file").data("index");

    selectedFiles.splice(index, 1);

    renderFiles();
});
</script>
@endsection