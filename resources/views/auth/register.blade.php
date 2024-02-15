<script>
document.addEventListener('DOMContentLoaded', function () {
    const fields = [
        { id: 'name', msg: 'Inserire un nome valido' },
        { id: 'last_name', msg: 'Inserire un cognome valido' },
        { id: 'address', msg: 'Inserire un indirizzo valido' },
        { id: 'email', msg: 'Inserire un indirizzo email valido' },
        { id: 'password', msg: 'Inserire una password valida' },
        { id: 'password-confirm', msg: 'La password risulta diversa o è vuota' }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        input.addEventListener('blur', () => validateField(input, field.msg));
    });

    const specialtiesCheckbox = document.querySelectorAll('input[type="checkbox"][name="specialties[]"]');
    specialtiesCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', () => validateSpecialties());
    });

    window.addEventListener('scroll', () => {
        if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight) {
            validateSpecialties();
        }
    });

    function validateField(input, message) {
        const value = input.value.trim();
        const errorMsgId = input.id + '-msg';
        const errorDiv = document.getElementById(errorMsgId);
        
        const isValid = value !== '' && (input.id !== 'email' || isValidEmail(value));
        
        if (!isValid) {
            input.classList.add('is-invalid');
            if (!errorDiv) {
                const parentDiv = input.parentElement;
                const newDiv = createErrorDiv(errorMsgId, message);
                parentDiv.appendChild(newDiv);
            }
        } else {
            input.classList.remove('is-invalid');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    }

    function validateSpecialties() {
        const selectedSpecialties = document.querySelectorAll('input[type="checkbox"][name="specialties[]"]:checked');
        const errorMsgId = 'specialties-msg';
        const input = document.getElementById('specialties-div');
        const errorDiv = document.getElementById(errorMsgId);
        
        if (selectedSpecialties.length === 0) {
            input.classList.add('is-invalid');
            if (!errorDiv) {
                const parentDiv = input.parentElement;
                const newDiv = createErrorDiv(errorMsgId, 'Selezionare una o più specializzazioni');
                parentDiv.appendChild(newDiv);
            }
        } else {
            input.classList.remove('is-invalid');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    }

    function isValidEmail(email) {
        const indexCh = email.indexOf('@');
        if (indexCh === -1 || indexCh === email.length - 1) {
            return false;
        }
        const emailSplit = email.substring(indexCh);
        return email.includes('@') && emailSplit.includes('.');
    }

    function createErrorDiv(id, message) {
        const newDiv = document.createElement('div');
        newDiv.classList.add('invalid-feedback');
        newDiv.textContent = message;
        newDiv.setAttribute('id', id);
        return newDiv;
    }
});

</script>

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrazione') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome*') }}</label>

                            <div id="name-div" class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Cognome*') }}</label>

                            <div id="last_name-div" class="col-md-6">
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo*') }}</label>

                            <div id="address-div" class="col-md-6">
                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="specialties" class="col-md-4 col-form-label text-md-right">{{ __('Specializzazione*') }}</label>
                        
                            <div class="col-md-6 form-control @error('specialties') is-invalid @enderror">
                                @foreach($specialties as $specialty)
                                <div class="form-check">
                                    <input type="checkbox" value="{{ $specialty->id }}" {{ in_array($specialty->id,
                                    old('specialties', [])) ? 'checked' : '' }} id="specialties{{ $specialty->id }}"
                                    name="specialties[]">
                                    <label class="form-check-label">{{ $specialty->name }}</label>
                                </div>
                                @endforeach

                                @error('specialties')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail*') }}</label>

                            <div id="email-div" class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password*') }}</label>

                            <div id="password-div" class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password*') }}</label>

                            <div id="password-confirm-div" class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrati') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection