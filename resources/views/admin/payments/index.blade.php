@extends('layouts.app')

@section('content')
    <div id="dropin-container"></div>
    <button id="submit-button">Purchase</button>
@endsection

@section('scripts')
    <script src="https://js.braintreegateway.com/web/dropin/1.31.0/js/dropin.min.js"></script>
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: '{{ $token }}',
            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.log('Error', err);
                        return;
                    }

                    // Invia il payload al server
                    fetch('/handle-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ nonce: payload.nonce })
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            alert('Pagamento completato con successo!');
                        } else {
                            alert('Errore durante il pagamento: ' + data.message);
                        }
                    });
                });
            });
        });
    </script>
@endsection
