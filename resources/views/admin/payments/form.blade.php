<!--Acquisto Braintree-->
<div class="container-fluid">
    <form id="payment-form" action="{{ route('admin.payment.process') }}" method="post">
        @csrf

        @foreach ($sponsorships as $sponsorship)
            <div class="card mb-3">
                <h6 class="mb-3">{{ $sponsorship->name }} </h6>
                <p> Questa sponsorizzazione ti consente di avere la priorità nella ricerca dei medici per la durata di
                    {{ substr($sponsorship->duration, 0, 2) }} ore, e ha un prezzo di {{ $sponsorship->price }} &euro;
                </p>
                <input type="radio" name="plan_id" value="{{ $sponsorship->id }}">
            </div>
        @endforeach
        <div id="dropin-container"></div>
        <input type="hidden" id="nonce" name="payment_method_nonce">
        <button type="submit">Pay</button>
    </form>
</div>

<script src="https://js.braintreegateway.com/web/dropin/1.41.0/js/dropin.min.js"></script>

<script>
    const form = document.getElementById('payment-form');
    console.dir(form);
    let clientToken = "{{ $clientToken }}";

    braintree.dropin.create({
        authorization: clientToken,
        container: '#dropin-container'
    }, function(createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            instance.requestPaymentMethod(function(err, payload) {
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
