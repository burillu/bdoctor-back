<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email-login');
    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });

    function validateEmail(input) {
        const value = input.value.trim();
        const errorMsgId = input.id + '-msg';
        const errorDiv = document.getElementById(errorMsgId);
        const isValid = value !== '' && isValidEmail(value);
        if (!isValid) {
            input.classList.add('is-invalid');
            if (!errorDiv) {
                const parentDiv = input.parentElement;
                const newDiv = createErrorDiv(errorMsgId, 'Inserire un indirizzo email valido');
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
                <div class="card-header">{{ __('Accesso') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="email" id="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email-login" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ricordati di me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Accedi') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Hai dimenticato la password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
