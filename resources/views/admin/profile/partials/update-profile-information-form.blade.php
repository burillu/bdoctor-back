@php
    $cv_path = 'storage/curriculums/';
@endphp
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
                <img class=""
                    src="{{ $data->image ? asset('storage/' . $data->image) : 'https://img.freepik.com/free-vector/illustration-businessman_53876-5856.jpg?size=626&ext=jpg&ga=GA1.1.87170709.1707696000&semt=ais' }}"
                    alt="profile_img">

            </div>
            <div>
                <label for="image">
                    {{ __('Scegli immagine profilo') }}
                </label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                    id="image">
                @error('image')
                    <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="mb-2">

                    <label for="name">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                        id="name" autocomplete="name" value="{{ old('name', $user->name) }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="last_name">{{ __('Last name') }}</label>
                    <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name"
                        id="last_name" autocomplete="last_name" value="{{ old('last_name', $user->last_name) }}"
                        autofocus>
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

                <input id="curriculum" name="curriculum" type="file"
                    class="form-control @error('curriculum') is-invalid @enderror"" />
                @error('curriculum')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <a class="btn btn-primary my-2" href="{{ Storage::url($data->curriculum) }}"download>Scarica PDF</a>

            </div>

            <label for="email">
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type=""
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                autocomplete="username" />

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
            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address"
                id="address" autocomplete="address" value="{{ old('address', $data->address) }}" autofocus>
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="tel">{{ __('Numero di telefono') }}</label>
            <input class="form-control @error('tel') is-invalid @enderror" type="" name="tel" id="tel"
                autocomplete="tel" value="{{ old('tel', $data->tel) }}" autofocus>
            @error('tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2">
            <input type="checkbox" id="visibility" name="visibility" value="{{ $data->visibility }}"
                {{ $data->visibility ? 'checked' : '' }}>
            <label for="visibility"><strong>Seleziona se sei disponibile al momento</strong></label>
        </div>

        <div class="mb-2">

            <div class="form-group">
                <h6>{{ __('Specialties') }}:</h6>
                <div class="container-fluid">
                    <div class="row">
                        @foreach ($specialties as $specialty)
                            <div class="form-check col-3 @error('specialties') is-invalid @enderror">
                                <input type="checkbox" name="specialties[]" value="{{ $specialty->id }}"
                                    {{ $data->specialties->contains($specialty->id) ? 'checked' : '' }}>
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
