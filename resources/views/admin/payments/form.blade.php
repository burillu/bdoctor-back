<!--Acquisto Braintree-->

<div class="container-fluid">
    @if (isset($errorMessages))
        <div class="alert alert-danger">
            {{ $errorMessages }}
        </div>
    @endif
    @if (is_null($expire_date) || !(strtotime($expire_date) > strtotime($now)))
        <form id="payment-form" action="{{ route('admin.payment.process') }}" method="post">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    @foreach ($sponsorships as $sponsorship)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card mb-3">
                                <div class="my-3 card-header">
                                    <h6 class="card-title">
                                        {{ $sponsorship->name }}
                                    </h6>
                                </div>
                                <div class="card-body">

                                    <p class> Avrai la priorità nella ricerca dei
                                        medici
                                        per la durata di {{ substr($sponsorship->duration, 0, -6) }} h, ad un prezzo
                                        di:
                                    <div><span
                                            class="text-decoration-line-through text-secondary">{{ number_format(round($sponsorship->price * 1.2, 1), 2, '.', ' ') }}
                                            &euro;</span>
                                        <span class="text-danger">
                                            {{ $sponsorship->price }}&euro; </span>
                                    </div>
                                    </p>
                                </div>

                                <div class="card-footer text-center my-bg-pacific px-3"><label class=""
                                        for="">
                                        Totale: {{ $sponsorship->price }} &euro;</label><br><input
                                        class="form-check-input " type="radio" name="plan_id"
                                        value="{{ $sponsorship->id }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="dropin-container"></div>
            <input type="hidden" id="nonce" name="payment_method_nonce">
            <button class="btn my-bg-primary mb-3" id='submit-pay' type="submit">Acquista</button>
        </form>
    @else
        <div class="alert alert-danger">
            Hai già acquistato la tua sponsorizzazione. Attendi il termine del periodo promozionale
            ({{ date('d/m/y \o\r\e H:i', strtotime($expire_date)) }})
        </div>

    @endif
    <div id="loader" class="d-none">
        <div  class="body">
            <div class="loader-container">
                <div class="loader"></div>
            </div>
        </div>
    </div>
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
            if (opzioneSelezionata) {
                if (errorDiv) {
                    errorDiv.remove();
                }
                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        const newDiv = createErrorDiv(errorMsgId,
                            `Errore nel pagamento: ${err}`);
                        parentDiv.appendChild(newDiv);
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                        return;
                    }
                    // Add the nonce to the form and submit
                    document.getElementById('nonce').value = payload.nonce;
                    loaderPay()
                    form.submit();
                });
            } else {
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
    function loaderPay(){
        const loader = document.getElementById('loader');
        loader.classList.remove('d-none');
    }
</script>

<style>
.body {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 9vh;
}
.loader-container {
  position: relative;
  width: 50px;
  height: 50px;
}

.loader {
  position: absolute;
  top: 5%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 5px solid transparent;
  border-top-color: #007bff;
  animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
