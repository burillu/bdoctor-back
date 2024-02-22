
<!--Acquisto Braintree-->
<div class="container-fluid">

 @if (isset($errorMessages))
        <div class="alert alert-danger">
            {{$errorMessages}}
        </div>
    @endif
    @if (is_null($expire_date) || !(strtotime($expire_date) > strtotime($now)))
        <form id="payment-form" action="{{ route('admin.payment.process') }}" method="post">
            @csrf

            @foreach ($sponsorships as $sponsorship)
                <div class="card mb-3">
                    <h6 class="mb-3">{{ $sponsorship->name }} </h6>
                    <p> Questa sponsorizzazione ti consente di avere la priorità nella ricerca dei medici per la durata
                        di
                        {{ substr($sponsorship->duration, 0, -6) }} ore, e ha un prezzo di {{ $sponsorship->price }}
                        &euro;
                    </p>
                    <input type="radio" name="plan_id" value="{{ $sponsorship->id }}">
                </div>
            @endforeach
            <div id="dropin-container"></div>
            <input type="hidden" id="nonce" name="payment_method_nonce">
            <button type="submit">Pay</button>
        </form>
    @else
        <div class="alert alert-danger">
            Hai già acquistato la tua sponsorizzazione, Attendi il termine del periodo promozionale
        </div>

    @endif

</div>

<script src="https://js.braintreegateway.com/web/dropin/1.41.0/js/dropin.min.js"></script>

<script>
    const form = document.getElementById('payment-form');
    console.dir(form);
    let clientToken = "{{ $clientToken }}";
    const opzioni = document.querySelectorAll('input[name="plan_id"]');
    let opzioneSelezionata = null;
    opzioni.forEach(function(opzione) {
        opzione.addEventListener('change', function() {
            opzioneSelezionata = document.querySelector('input[name="plan_id"]:checked').value;
        });
    });
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
            const input = document.getElementById('submit-pay');
            const errorMsgId = input.id + '-msg';
            const parentDiv = input.parentElement;
            const errorDiv = document.getElementById(errorMsgId);
            if(opzioneSelezionata){
                if (errorDiv) {
                    errorDiv.remove();
                }
                instance.requestPaymentMethod(function(err, payload) {
                if (err) {
                    const newDiv = createErrorDiv(errorMsgId, `Errore nel pagamento: ${err}`);
                    parentDiv.appendChild(newDiv);
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                    return;
                }
                // Add the nonce to the form and submit
                document.getElementById('nonce').value = payload.nonce;
                form.submit();
            });
            }else{
                const newDiv = createErrorDiv(errorMsgId, 'Scegliere un piano di sponsorizzazione');
                parentDiv.appendChild(newDiv);
                if (errorDiv) {
                    errorDiv.remove();
                }
                
            }
        });
    });

    function createErrorDiv(id, message) {
        const newDiv = document.createElement('div');
        newDiv.classList.add('text-red');
        newDiv.textContent = message;
        newDiv.setAttribute('id', id);
        return newDiv;
    }
</script>
