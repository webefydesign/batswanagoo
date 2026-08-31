@extends('layouts.frontend')
@section('title', 'My Balance | Salone Goo')
@section('customStyles')
    <style>
    .all-list-sh .eve-box {
        display: flex;
        align-items: stretch;
    }
    .forprfile .container {
        background: none;
        border:none;
        padding: 30px;
        max-width: 1300px;
    }
    .forprfile .cr .container {padding:0;}
    .sl-notifications {
        /* background: #e9f2f8; */
        /* border-radius: 8px; */
        /* padding: 10px; */
        width: 100%;
    }

    .notification-item {
        background: transparent;
        border-bottom: 1px solid #cecece;
        transition: background 0.2s ease, opacity 0.3s ease;
    }

    .notification-item.credit {
        background: #f7fcff;
        border-left: 3px solid #1eaf38;
    }
    .notification-item.debit {
        background: #f7fcff;
        border-left: 3px solid #dc3545;
    }

    .notification-item:hover {
        background: #eef7ff;
    }

    .notification-images {
        min-width: 40px;
        flex-wrap: wrap;
    }
    .notification-content {
        font-size: 12px;
    }

    .notification-images img {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .mark-read-btn {
        font-size: 12px;
        padding: 4px 8px;
    }
    .panel {
        position: relative;
    }
    .bottom-btns {
        position: absolute;
        width: 100%;
        bottom: -50px;
        right: 0px;
        padding: 10px;
    }
    .money-field {

    }
    .tab-heads h3 {
        font-size: 19px;
        flex: 0 0 40%;
        max-width: 40%;
        margin: 0;
        align-self: center;
        font-weight: 600;
    }
    .empty-wallet-message {
        height: 300px;
        display: flex;
        flex-direction: column;
        align-content: center;
        justify-content: center;
        align-items: center;
        vertical-align: middle;
    }
    .empty-wallet-message h3 {
        font-size: 24px;
        font-weight: 600;
        margin-top: 20px;
    }
    .empty-wallet-message p {
        font-size: 16px;
        font-weight: 400;
    }
    button#payBtn {
        margin: 0 auto;
        display: block;
    }
    #successDiv {
        text-align: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-top: 0;
    }
    #successDiv .success-icon {
        font-size: 48px;
        color: #1eaf38;
        margin-bottom: 20px;
    }
    #successDiv .success-text {
        font-size: 18px;
        font-weight: 600;
    }
    #successDiv .success-text p {
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 0;
    }
    .modal-header h4.modal-title {
        font-size: 18px;
        font-weight: 500;
    }
    .modal-header .close {
        font-size: 18px;
        font-weight: 500;
    }
    .accordion button {
        font-size: 14px;
        font-weight: normal;
    }
    .modal-content {
        border-radius: 20px;
        padding: 5px;
        border: 2px solid #38a745;
    }
    .modal-open {
        overflow: hidden !important;
        height: 100vh !important;
        position: fixed !important;
        width: 100% !important;
    }
    #stripeSuccessDiv {
        text-align: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-top: 0;
    }
    </style>
@endsection
@section('content')
<div class="m-container forprfile">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="panel-group">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            @include('frontend.dashboard.profile_main_nav')
                        </div><!-- panl-body -->
                    </div>
                </div>                    
            </div><!-- sm4 -->
            <div class="col-sm-9">
                <div class="panel-group">
                    <div class="panel panel-default">
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                        @endif
                        <form action="{{route('dashboard.markAllAsRead')}}" method="post" id="markAllAsReadForm">
                        @csrf
                        </form>
                        <div class="panel-heading" @if($transactions->count() == 0) style="display: none;" @endif>
                            <div class="tab-heads d-flex justify-content-between align-items-center">
                                <h3>My Balance: <span class="badge badge-success">{{baseSymbol()}} {{number_format(auth()->user()->wallet->balance ?? 0, 2)}}</span></h3>
                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-success" id="addMoneyBtn">Add Money</a>                                    
                            </div><!-- tab-heads -->

                        </div><!-- panel-heading -->
                        <div class="panel-body">
                            <div class="sl-notifications">                                
                                @forelse($transactions as $transaction)
                                <div class="notification-item {{ $transaction->type }} d-flex align-items-center p-3 mb-2 rounded">
                                    <div class="notification-images d-flex me-2">
                                    <a href="javascript:;" class="view-msg"><img src="{{asset('assets_frontend/img/money.png')}}" class="img-responsive"></a>
                                    </div>
                                    <div class="notification-content flex-grow-1">
                                        <p class="mb-1">
                                            <strong><a href="javascript:;" class="view-msg">{{ $transaction->type == 'credit' ? 'Balance Credited' : 'Balance Debited' }}</a></strong> <span class="badge {{ $transaction->type == 'credit' ? 'badge-success' : 'badge-danger' }}">{{baseSymbol()}} {{number_format($transaction->amount, 2)}}</span> ~ {{ $transaction->description }}
                                        </p>
                                    </div>                                    
                                    <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                </div>                                
                                @empty
                                <div class="empty-wallet-message">
                                    <div class="empty-wallet-icon">
                                        <img src="{{asset('assets_frontend/img/no-money.png')}}" class="img-responsive">
                                    </div>
                                    <h3>Your wallet is empty</h3>
                                    <p>Add funds to your wallet to get started</p>
                                    <a href="javascript:;" id="addMoneyBtn" class="btn btn-outline-success">Add Money</a>
                                </div>
                                @endforelse                                                            
                            </div>
                            <div class="bottom-btns">
                                {{ $transactions->links('pagination::bootstrap-4') }}
                            </div>
                        </div><!-- panl-body -->
                    </div>
                </div><!-- sm8 -->
            </div>
        </div>
    </div>
</div>

<!-- Add Wallet Modal -->
<div id="addWalletModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <!-- Modal content-->
      <div class="modal-content" id="addWalletContent">
        <div class="modal-header">
            <h4 class="modal-title text-success">Recharge your wallet</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addMoneyForm">
                @csrf
                <div class="form-group">
                    <input type="number" class="form-control money-field" id="amount" name="amount" min="20" required placeholder="Enter amount in {{baseSymbol()}}">
                </div>
                 <!-- Accordion for Payment Methods -->
                <div class="accordion p-0" id="paymentAccordion">

                    <!-- Debit/Credit Card -->
                    <div class="card">
                        <div class="card-header bg-success p-0" id="headingCard">
                            <h2 class="mb-0">
                            <button class="btn btn-link payment-method-btn btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                                <input type="radio" name="payment_method" value="card" checked> Debit / Credit Card
                            </button>
                            </h2>
                        </div>

                        <div id="collapseCard" class="collapse show" aria-labelledby="headingCard" data-parent="#paymentAccordion">
                            <div class="card-body">
                            <p>Pay instantly with Visa, MasterCard, or other supported cards.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="card">
                        <div class="card-header bg-success p-0" id="headingBank">
                            <h2 class="mb-0">
                            <button class="btn btn-link payment-method-btn btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseBank" aria-expanded="false" aria-controls="collapseBank">
                                <input type="radio" name="payment_method" value="bank"> Bank Transfer
                            </button>
                            </h2>
                        </div>

                        <div id="collapseBank" class="collapse" aria-labelledby="headingBank" data-parent="#paymentAccordion">
                            <div class="card-body">
                                {{-- <p>Transfer the amount manually to our bank account. Once verified, your wallet will be recharged.</p> --}}
                                <div>
                                    {!! getWalletSettings()['bank_details'] ?? '' !!}
                                </div>
                                <div class="form-group">
                                    <hr>
                                    <label for="bank_receipt">Proof of Payment</label>
                                    <input type="file" class="form-control" id="bank_receipt" name="bank_receipt" accept="image/*" maxlength="2048">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orange Money -->
                    <div class="card">
                        <div class="card-header bg-success p-0" id="headingOrange">
                            <h2 class="mb-0">
                            <button class="btn btn-link payment-method-btn btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseOrange" aria-expanded="false" aria-controls="collapseOrange">
                                <input type="radio" name="payment_method" value="orange"> Orange Money
                            </button>
                            </h2>
                        </div>

                        <div id="collapseOrange" class="collapse" aria-labelledby="headingOrange" data-parent="#paymentAccordion">
                            <div class="card-body">
                                <div>
                                    {!! getWalletSettings()['orange_details'] ?? '' !!}
                                </div>                                
                                <div class="form-group">
                                    <hr>
                                    <label for="orange_receipt">Proof of Payment</label>
                                    <input type="file" class="form-control" id="orange_receipt" name="orange_receipt" accept="image/*" maxlength="2048">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3 text-center">
                    <button type="submit" class="btn btn-outline-success w-80">Proceed</button>
                </div>
            </form>
            <div id="stripeDiv" style="display:none;">
                {{-- <hr> --}}
                <form id="payment-form">
                    <div id="card-element"></div>
                    <button id="payBtn" class="btn btn-success mt-3" type="submit">Pay Now</button>
                </form>
            </div>
            <div id="successDiv" style="display:none;">
                <div class="success-message">
                    <div class="success-icon">
                        <h3>Thank you for the payment!</h3>
                    </div>
                    <div class="success-text">
                    <p>The amount will be added to your wallet shortly after verification.</p>
                </div>                
            </div>
        </div>
        <div id="stripeSuccessDiv" style="display:none;">
            <div class="success-message">
                <div class="success-icon">
                    <h3>Payment Successful!</h3>
                </div>
                <div class="success-text">
                    <p>The amount has been added to your wallet.</p>
                    <a href="{{ route('dashboard.wallet') }}" class="btn btn-success">Reload the page</a>
                </div>                
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@section('customScripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    let elements, card, clientSecret;

    $(document).on('click', '#addMoneyBtn', function() {
        // Reset form
        $('#addMoneyForm')[0].reset();
        $('#stripeDiv').hide();
        $('#successDiv').hide();
        $('#stripeSuccessDiv').hide();
        $('#addMoneyForm').show();
        
        // Reset Stripe elements if they exist
        if (card) {
            card.clear();
        }
        
        $('#addWalletModal').modal('show');
    });

    $(document).ready(function () {
        // Handle "Proceed to Payment" button
        $('#addMoneyForm').on('submit', function (e) {
            e.preventDefault();
            
            let amount = $('#amount').val();
            let paymentMethod = $('input[name="payment_method"]:checked').val();
            
            // Validation
            if (!amount || amount < 1) {
                Swal.fire('Error', 'Please enter a valid amount (minimum 1)', 'error');
                return;
            }
            
            if (!paymentMethod) {
                Swal.fire('Error', 'Please select a payment method', 'error');
                return;
            }
            
            // Validate receipts for bank/orange
            if (paymentMethod === 'bank' && !$('#bank_receipt')[0].files.length) {
                Swal.fire('Error', 'Please upload bank transfer receipt', 'error');
                return;
            }
            
            if (paymentMethod === 'orange' && !$('#orange_receipt')[0].files.length) {
                Swal.fire('Error', 'Please upload Orange Money receipt', 'error');
                return;
            }
            
            // Disable submit button
            $(this).find('button[type="submit"]').prop('disabled', true).text('Processing...');
            
            if (paymentMethod == 'card') {
                // Card payment - create Stripe intent
                $.ajax({
                    url: '{{ route("createWalletIntent") }}',
                    type: 'POST',
                    data: {
                        amount: amount,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                            $('#addMoneyForm button[type="submit"]').prop('disabled', false).text('Proceed');
                            return;
                        }
                        
                        clientSecret = data.clientSecret;

                        // Show Stripe div
                        $('#stripeDiv').slideDown();
                        $('#addMoneyForm').slideUp();

                        // Initialize Stripe elements only once
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
                    },
                    error: function (xhr) {
                        let errorMsg = 'Error creating payment intent.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                        $('#addMoneyForm button[type="submit"]').prop('disabled', false).text('Proceed');
                    }
                });
            } else {
                // Bank/Orange payment
                var formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route("confirmWalletPayment") }}',
                    type: 'POST',
                    data: formData,
                    enctype: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                            $('#addMoneyForm button[type="submit"]').prop('disabled', false).text('Proceed');
                            return;
                        }
                        
                        $('#successDiv').slideDown();
                        $('#addMoneyForm').slideUp();
                        
                        // Reload page after 3 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function (xhr) {
                        let errorMsg = 'Error confirming payment.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                        $('#addMoneyForm button[type="submit"]').prop('disabled', false).text('Proceed');
                    }
                });
            }
        });

        // Handle Stripe payment
        $('#payment-form').on('submit', function (e) {
            e.preventDefault();
            $('#payBtn').prop('disabled', true).text('Processing...');

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            }).then(function (result) {
                if (result.error) {
                    Swal.fire('Error', result.error.message, 'error');
                    $('#payBtn').prop('disabled', false).text('Pay Now');
                } else if (result.paymentIntent.status === 'succeeded') {
                    // Confirm payment on backend
                    $.post('{{ route("confirmWalletPayment") }}', {
                        amount: $('#amount').val(),
                        _token: '{{ csrf_token() }}',
                        payment_intent: result.paymentIntent.id,
                        payment_method: 'card'
                    }, function(response) {
                        if (response.error) {
                            Swal.fire('Error', response.error, 'error');
                            return;
                        }
                        
                        $('#stripeSuccessDiv').slideDown();
                        $('#stripeDiv').slideUp();
                        $('#addMoneyForm').slideUp();
                        
                        // Reload page after 2 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }).fail(function(xhr) {
                        let errorMsg = 'Payment confirmation failed.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                    });
                }
            });
        });
        
        // Handle payment method selection
        $(document).on('click', '.payment-method-btn', function() {
            $(this).find('input[name="payment_method"]').prop('checked', true);
        });
        
        // Modal close - reset form
        $('#addWalletModal').on('hidden.bs.modal', function () {
            $('#addMoneyForm')[0].reset();
            $('#stripeDiv').hide();
            $('#successDiv').hide();
            $('#stripeSuccessDiv').hide();
            $('#addMoneyForm').show();
            $('#addMoneyForm button[type="submit"]').prop('disabled', false).text('Proceed');
            
            if (card) {
                card.clear();
            }
        });
    });
</script>
@endsection
