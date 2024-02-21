@extends('admin.dashboard')
@section('dashboard_content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <script src="https://js.braintreegateway.com/web/dropin/1.31.0/js/dropin.min.js"></script>
</head>
<body>
    <form id="payment-form" action="{{ route('admin.payment.process') }}" method="post">
        @csrf
        <div id="dropin-container"></div>
        <input type="hidden" id="nonce" name="payment_method_nonce">
        <button type="submit">Pay</button>
    </form>

    <script>
        var form = document.getElementById('payment-form');
        var clientToken = "{{ $clientToken }}";

        braintree.dropin.create({
            authorization: clientToken,
            container: '#dropin-container'
        }, function (createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                    }

                    // Add the nonce to the form and submit
                    document.getElementById('nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>
</body>
</html>
@endsection
