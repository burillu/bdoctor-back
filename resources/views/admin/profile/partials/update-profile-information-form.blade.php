@php
$cv_path = 'storage/curriculums/'
@endphp
<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf

    </form>

    <form method="post" action="{{ route('admin.profile.update', $data->id) }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="d-flex align-items-center ">
            <div class="mb-2 mx-3 rounded-circle overflow-hidden custom-border  ">
                <img class="profile-img " src="{{asset('storage/images/' . $user->remember_token)}}" alt="profile_img">
            </div>
            <div>
                <label for="image">
                    {{ __('Scegli immagine profilo') }}
                </label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                <div class="mb-2">

                    <label for="name">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" autocomplete="name"
                        value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="last_name">{{ __('Last name') }}</label>
                    <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" id="last_name" autocomplete="last_name"
                        value="{{ old('last_name', $user->last_name) }}" required autofocus>
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
                <input id="curriculum" name="curriculum" type="file" class="form-control" />
                <a class="btn btn-primary my-2" href="{{ Storage::url('public/curriculums/'. $user->remember_token) }}"
                    download>Scarica PDF</a>
            </div>

            <label for="email">
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                required autocomplete="username" />

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
            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" autocomplete="address"
                value="{{ old('address', $data->address) }}" required autofocus>
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="tel">{{ __('Numero di telefono') }}</label>
            <input class="form-control @error('tel') is-invalid @enderror" type="text" name="tel" id="tel" autocomplete="tel"
                value="{{ old('tel', $data->tel) }}" required autofocus>
            @error('tel')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <input type="checkbox" id="visibility" name="visibility" value="{{ $data->visibility}}" {{
                $data->visibility ? 'checked' : '' }}>
            <label for="visibility"><strong>Spunta se sei disponibile al momento</strong></label>
        </div>

        <div class="mb-2">

            <div class="form-group">
                <h6>{{ __('Specialties') }}:</h6>
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($specialties as $specialty)
                        <div class="form-check col-3 @error('specialties') is-invalid @enderror">
                            <input type="checkbox" name="specialties[]" value="{{ $specialty->id }}" {{
                                $data->specialties->contains($specialty->id) ? 'checked' : '' }}>
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

            @if (session('status') === 'profile-updated')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('profile-status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='profile-status' class="fs-5 text-muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>