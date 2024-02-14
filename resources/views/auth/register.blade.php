<script>
    document.addEventListener('DOMContentLoaded', function () {
        const name = document.getElementById('name');
        const surname = document.getElementById('last_name');
        const address = document.getElementById('address');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const password_confirm = document.getElementById('password-confirm');

        name.addEventListener('blur', function () {
            if (name.value.trim() === '') {
                let removeDiv = document.getElementById('name-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                name.classList.add('is-invalid');
                const nameDiv = document.getElementById('name-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Inserire un nome valido';
                newDiv.setAttribute('id', 'name-msg');
                nameDiv.appendChild(newDiv);
            } else {
                name.classList.remove('is-invalid');
                let removeDiv = document.getElementById('name-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

        surname.addEventListener('blur', function () {
            if (surname.value.trim() === '') {
                let removeDiv = document.getElementById('surname-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                surname.classList.add('is-invalid');
                const surnameDiv = document.getElementById('last_name-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Inserire un cognome valido';
                newDiv.setAttribute('id', 'surname-msg');
                surnameDiv.appendChild(newDiv);
            } else {
                surname.classList.remove('is-invalid');
                let removeDiv = document.getElementById('surname-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

        address.addEventListener('blur', function () {
            if (address.value.trim() === '') {
                address.classList.remove('is-invalid');
                let removeDiv = document.getElementById('address-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                address.classList.add('is-invalid');
                const addressDiv = document.getElementById('address-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Inserire un indirizzo valido';
                newDiv.setAttribute('id', 'address-msg');
                addressDiv.appendChild(newDiv);
            } else {
                address.classList.remove('is-invalid');
                let removeDiv = document.getElementById('address-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

        email.addEventListener('blur', function () {
            if (email.value.trim() === '') {
                email.classList.remove('is-invalid');
                let removeDiv = document.getElementById('email-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                email.classList.add('is-invalid');
                const emailDiv = document.getElementById('email-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Inserire un indirizzo email valido';
                newDiv.setAttribute('id', 'email-msg');
                emailDiv.appendChild(newDiv);
            } else {
                email.classList.remove('is-invalid');
                let removeDiv = document.getElementById('email-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

        password.addEventListener('blur', function () {
            if (password.value.trim() === '') {
                password.classList.remove('is-invalid');
                let removeDiv = document.getElementById('password-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                password.classList.add('is-invalid');
                const passwordDiv = document.getElementById('password-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Inserire una password valida';
                newDiv.setAttribute('id', 'password-msg');
                passwordDiv.appendChild(newDiv);
            } else {
                password.classList.remove('is-invalid');
                let removeDiv = document.getElementById('password-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

        password_confirm.addEventListener('blur', function () {
            if (password_confirm.value.trim() === '') {
                password_confirm.classList.remove('is-invalid');
                let removeDiv = document.getElementById('password-confirm-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
                password_confirm.classList.add('is-invalid');
                const passwordConfirmDiv = document.getElementById('password-confirm-div');
                let newDiv = document.createElement('div');
                newDiv.classList.add('invalid-feedback');
                newDiv.textContent = 'Confermare la password';
                newDiv.setAttribute('id', 'password-confirm-msg');
                passwordConfirmDiv.appendChild(newDiv);
            } else {
                password_confirm.classList.remove('is-invalid');
                let removeDiv = document.getElementById('password-confirm-msg');
                if (removeDiv) {
                    let parentDiv = removeDiv.parentNode;
                    parentDiv.removeChild(removeDiv);
                }
            }
        });

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
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

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
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Cognome')
                                }}</label>

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
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo')
                                }}</label>

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
                            <label for="specialties" class="col-md-4 col-form-label text-md-right">{{
                                __('Specializzazione') }}</label>

                            <div id="specialties-div"
                                class="col-md-6 form-control @error('specialties') is-invalid @enderror">
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
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                }}</label>

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
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                                }}</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm
                                Password') }}</label>

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