<script>
    document.addEventListener('DOMContentLoaded', function () {
    let errors = [];
    console.log()
    const fields = [
        { id: 'email', msg: 'Inserire un indirizzo email valido' },
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        input.addEventListener('blur', () => validateField(input, field.msg));
    });

    const form = document.getElementById('forgot-pas-form');
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
        const input = document.getElementById('forgot-pas-submit');
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
        const value = input.value.trim();
        const errorMsgId = input.id + '-msg';
        const errorDiv = document.getElementById(errorMsgId);
        let isValid = value !== '' && isValidEmail(value);
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
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form id="forgot-pas-form" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <div class="col-md-6 offset-md-4">
                                <button id="forgot-pas-submit" type="submit" class="btn btn-primary">
                                    {{ __('Invia link di reset password') }}
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
