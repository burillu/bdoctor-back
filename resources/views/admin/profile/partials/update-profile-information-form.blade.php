<script>
document.addEventListener('DOMContentLoaded',function(){
// Campi obbligatori
    const fields = [
            { id: 'name-edit', msg: 'Inserire un nome valido' },
            { id: 'last_name-edit', msg: 'Inserire un cognome valido' },
            { id: 'address-edit', msg: 'Inserire un indirizzo valido' },
            { id: 'email-edit', msg: 'Inserire un indirizzo email valido' },
        ];
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            input.addEventListener('blur', function () {
                let pasVal = null;
                validateField(input, field.msg);
            });
        });
       
//Campi non obbligatori

//Immagine e PDF
const image = document.getElementById('image');
image.addEventListener('change', function() {
    validateFileFormat(this, ['jpg', 'jpeg'], 'Formato file non supportato. Si prega di selezionare un file JPG.');
});

const curriculum = document.getElementById('curriculum');
curriculum.addEventListener('change', function() {
    validateFileFormat(this, ['pdf'], 'Formato file non supportato. Si prega di selezionare un file PDF.');
});

//Funzioni
function validateField(input, message) {
    const inputId = input.getAttribute('id');
    const errorMsgId = inputId + '-msg';
    const errorDiv = document.getElementById(errorMsgId);
    if (input.value.trim() === '' || input.id === 'email' && !isValidEmail(input.value) || input.getAttribute('id') === 'image' || input.getAttribute('id') === 'curriculum' ) {
        console.log(message);
        input.classList.add('is-invalid');
        if (!errorDiv) {
            const parentDiv = input.parentElement;
            const newDiv = document.createElement('div');
            newDiv.classList.add('invalid-feedback');
            newDiv.textContent = message;
            newDiv.setAttribute('id', errorMsgId);
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
    let indexCh = email.indexOf('@');
    if (indexCh === -1 || indexCh === email.length - 1) {
        return false;
    }
    let emailSplit = email.substring(indexCh);
    return email.includes('@') && emailSplit.includes('.');
}

function validateFileFormat(input, allowedExtensions, errorMsg) {
    const file = input.files[0];
    const fileName = file.name;
    const fileExtension = fileName.split('.').pop().toLowerCase();
    
    if (allowedExtensions.includes(fileExtension)) {
        input.classList.remove('is-invalid');
        const errorDiv = document.getElementById(input.id + '-msg');
        if (errorDiv) {
            errorDiv.remove();
        }
    } else {
        validateField(input, errorMsg);
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
                <input id="curriculum" name="curriculum" type="file" class="form-control @error('curriculum') is-invalid @enderror" />
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

            <input id="email-edit" name="email" type="" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" autocomplete="username" />

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
                    <div class="row">
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