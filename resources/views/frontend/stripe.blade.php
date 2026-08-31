<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("{{ config('services.stripe.key') }}");
    stripe.redirectToCheckout({
        sessionId: '{{$session_id}}'
    }).then(function (result) {
        
    });
</script>