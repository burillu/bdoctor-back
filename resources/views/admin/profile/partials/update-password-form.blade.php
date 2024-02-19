<script>
    document.addEventListener('DOMContentLoaded', function () {
        let errors = [];
        const fields = [
            { id: 'update-current_password', msg: 'Inserire una password valida (almeno 8 caratteri)' },
            { id: 'update-password', msg: 'Inserire una password valida (almeno 8 caratteri)' },
            { id: 'update-password_confirmation', msg: 'La password risulta diversa o è vuota' }
        ];
    
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            input.addEventListener('blur', () => validateField(input, field.msg));
        });
    
        const form = document.getElementById('update-pas-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const inputsVal = fields.map(field => {
                const input = document.getElementById(field.id);
                return input.value.trim();
            });
            const emptyFields = inputsVal.filter(val => val === '').length;
            if (emptyFields === 0) {
                if (errors.length === 0) {
                    this.submit();
                } else {
                    handleValidationErrors('Il modulo contiene errori di validazione. Correggi prima di inviare.');
                }
            } else {
                handleValidationErrors('Vi sono dei campi non compilati');
            }
        });
    
        function handleValidationErrors(errorMessage) {
            const input = document.getElementById('update-pas');
            const errorMsgId = input.id + '-msg';
            const parentDiv = input.parentElement;
            const errorDiv = document.getElementById(errorMsgId);
            if (errorDiv) {
                errorDiv.remove();
            }
            const newDiv = createErrorDiv(errorMsgId, errorMessage);
            newDiv.classList.remove('invalid-feedback');
            newDiv.classList.add('text-red');
            parentDiv.appendChild(newDiv);
        }
    
        function validateField(input, message) {
            console.log(input)
            const value = input.value.trim();
            const errorMsgId = input.id + '-msg';
            const errorDiv = document.getElementById(errorMsgId);
            let isValid = true;
            switch (input.id) {
                case 'update-current_password':
                    isValid = value !== '' && value.length >= 8;
                    break;
                case 'update-password':
                    isValid = value !== '' && value.length >= 8;
                    break;
                case 'update-password_confirmation':
                    isValid = value !== '' && confirmPas(value);
            }
            if (!isValid) {
                input.classList.add('is-invalid');
                if (!errorDiv) {
                    const parentDiv = input.parentElement;
                    const newDiv = createErrorDiv(errorMsgId, message);
                    parentDiv.appendChild(newDiv);
                    errors.push(message);
                }
            } else {
                input.classList.remove('is-invalid');
                if (errorDiv) {
                    errorDiv.remove();
                    errors.splice(errors.indexOf(message), 1);
                }
            }
        }
    
        function createErrorDiv(id, message) {
            const newDiv = document.createElement('div');
            newDiv.classList.add('invalid-feedback');
            newDiv.textContent = message;
            newDiv.setAttribute('id', id);
            return newDiv;
        }
    
        function confirmPas(pas){
            const originalPas = document.getElementById('update-password');
            return pas === originalPas.value
        }
    
    });

</script>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Aggiorna la password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assicurati che il tuo account utilizzi una password lunga e casuale per rimanere sicuro.') }}
        </p>
    </header>

    <form id="update-pas-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-2">
            <label for="current_password">{{__('Current Password')}}</label>
            <input class="mt-1 form-control" type="password" name="current_password" id="update-current_password" autocomplete="current-password">
            @error('current_password')
            <span class="invalid-feedback mt-2" role="alert">
                <strong>{{ $errors->updatePassword->get('current_password') }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="password">{{__('Nuova Password')}}</label>
            <input class="mt-1 form-control" type="password" name="password" id="update-password" autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback mt-2" role="alert">
                <strong>{{ $errors->updatePassword->get('password')}}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">

            <label for="password_confirmation">{{__('Conferma Password')}}</label>
            <input class="mt-2 form-control" type="password" name="password_confirmation" id="update-password_confirmation" autocomplete="new-password">
            @error('password_confirmation')
            <span class="invalid-feedback mt-2" role="alert">
                <strong>{{ $errors->updatePassword->get('password_confirmation')}}</strong>
            </span>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button id="update-pas" type="submit" class="btn btn-primary">{{ __('Salva') }}</button>

            @if (session('status') === 'password-updated')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='status' class=" fs-5 text-muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>