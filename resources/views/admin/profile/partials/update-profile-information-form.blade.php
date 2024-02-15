<script>
    document.addEventListener('DOMContentLoaded', function() {
    const fields = [
        { id: 'name-edit', msg: 'Inserire un nome valido' },
        { id: 'last_name-edit', msg: 'Inserire un cognome valido' },
        { id: 'address-edit', msg: 'Inserire un indirizzo valido' },
        { id: 'email-edit', msg: 'Inserire un indirizzo email valido' },
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        input.addEventListener('blur', () => validateField(input, field.msg));
    });

    const fileInputs = [
        { id: 'image', extensions: ['jpg', 'jpeg'], msg: 'Formato file non supportato. Si prega di selezionare un file JPG.' },
        { id: 'curriculum', extensions: ['pdf'], msg: 'Formato file non supportato. Si prega di selezionare un file PDF.' },
    ];

    fileInputs.forEach(fileInput => {
        const input = document.getElementById(fileInput.id);
        input.addEventListener('change', () => validateFileFormat(input, fileInput.extensions, fileInput.msg));
    });

    const specialtiesCheckbox = document.querySelectorAll('input[type="checkbox"][name="specialties[]"]');
    specialtiesCheckbox.forEach(checkbox => {
        checkbox.addEventListener('change', validateSpecialties);
    });

    const telInput = document.getElementById('tel');
    telInput.addEventListener('blur', function() {
        validatePhoneNumber(this);
    });

    function validateField(input, message) {
        const value = input.value.trim();
        const errorMsgId = input.id + '-msg';
        const errorDiv = document.getElementById(errorMsgId);

        const isValid = value !== '' && (input.id !== 'email-edit' || isValidEmail(value));
        
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

    function isValidEmail(email) {
        const indexCh = email.indexOf('@');
        if (indexCh === -1 || indexCh === email.length - 1) {
            return false;
        }
        const emailSplit = email.substring(indexCh);
        return email.includes('@') && emailSplit.includes('.');
    }

    function validateFileFormat(input, allowedExtensions, errorMsg) {
        const file = input.files[0];
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        const isValid = allowedExtensions.includes(fileExtension);

        if (!isValid) {
            validateField(input, errorMsg);
        }
    }

    function validateSpecialties() {
        const selectedSpecialties = document.querySelectorAll('input[type="checkbox"][name="specialties[]"]:checked');
        const input = document.getElementById('specialties-div');
        const errorDiv = document.getElementById('specialties-msg');
        
        const isValid = selectedSpecialties.length > 0;

        if (!isValid) {
            input.classList.add('is-invalid');
            if (!errorDiv) {
                const parentDiv = input.parentElement;
                const newDiv = createErrorDiv('specialties-msg', 'Selezionare una o più specializzazioni');
                parentDiv.appendChild(newDiv);
            }
        } else {
            input.classList.remove('is-invalid');
            if (errorDiv) {
                errorDiv.remove();
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

    function validatePhoneNumber(input) {
        const telValue = input.value.trim();
        const telRegex = /^[0-9]{10}$/;

        if (!telRegex.test(telValue)) {
            if(input.parentNode.querySelector('.invalid-feedback')){
                input.classList.remove('is-invalid');
                input.parentNode.querySelector('.invalid-feedback').remove()
            }
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('invalid-feedback');
            errorDiv.textContent = 'Inserire un numero di telefono valido';
            input.parentNode.appendChild(errorDiv);
        } else {
            input.classList.remove('is-invalid');
            const errorDiv = input.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    }
});

</script>
<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
        @if (session('status') === 'profile-updated')
        <script>
            const show = true;
            setTimeout(() => show = false, 2000)
            const el = document.getElementById('profile-status')
            if (show) {
                el.style.display = 'block';
            }
        </script>
        <div id='profile-status' class="fs-5 alert alert-success">{{ __('Your profile has been updated') }}</div>
        @endif
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf

    </form>

    <form method="post" action="{{ route('admin.profile.update', $data->id) }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="d-flex align-items-center ">

            <div class="mb-2 mx-3 rounded-circle overflow-hidden custom-border profile-img">
                <img class="" src="{{ $data->image ? asset('storage/' . $data->image) : 'https://img.freepik.com/free-vector/illustration-businessman_53876-5856.jpg?size=626&ext=jpg&ga=GA1.1.87170709.1707696000&semt=ais' }}" alt="profile_img">
            </div>
            <div>
                <div class="mb-2">
                    <label for="image">
                        {{ __('Scegli immagine profilo') }}
                    </label>
                    <input type="file" accept="image/jpeg" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-2">

                    <label for="name">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name-edit"
                        autocomplete="name" value="{{ old('name', $user->name) }}" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="last_name">{{ __('Last name') }}</label>
                    <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name-edit" autocomplete="last_name" value="{{ old('last_name', $user->last_name) }}" autofocus>
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-2">

            <label for="curriculum">
                {{ __('Curriculum (PDF)') }}
            </label>
            <div>
                <input id="curriculum" name="curriculum" accept="application/pdf"type="file" class="form-control @error('curriculum') is-invalid @enderror" />
                @error('curriculum')
                    <span class=" invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if ($data->curriculum)
                    <a class="btn btn-primary my-2" href="{{ asset('storage/' . $data->curriculum) }}" download>ScaricaPDF</a>
                @endif
            </div>

            <label for="email">
                {{ __('Email') }}
            </label>

            <input id="email-edit" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" autocomplete="username" />

            @error('email')
                <span class="text-danger mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-muted">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="btn btn-outline-dark">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-success">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
            @endif


        </div>

        <div class="mb-2">
            <label for="address">{{ __('Address') }}</label>
            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address-edit" autocomplete="address" value="{{ old('address', $data->address) }}" autofocus>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="tel">{{ __('Numero di telefono') }}</label>
            <input class="form-control @error('tel') is-invalid @enderror" type="" name="tel" id="tel" autocomplete="tel" value="{{ old('tel', $data->tel) }}" autofocus>
            @error('tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <input type="checkbox" id="visibility" name="visibility" value="{{ $data->visibility }}" {{ $data->visibility ? 'checked' : '' }}>
            <label for="visibility"><strong>Seleziona se sei disponibile al momento</strong></label>
        </div>

        <div class="mb-2">

            <div class="form-group">
                <h6>{{ __('Specialties') }}:</h6>
                <div class="container-fluid">
                    <div class="row" id="specialties-div">
                        @foreach ($specialties as $specialty)
                            <div class="form-check col-3 @error('specialties') is-invalid @enderror">
                                <input type="checkbox" name="specialties[]" value="{{ $specialty->id }}" {{ $data->specialties->contains($specialty->id) ? 'checked' : '' }}>
                                <label for="">{{ $specialty->name }}</label>
                            </div>
                        @endforeach
                        @error('specialties')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
        </div>
    </form>
</section>