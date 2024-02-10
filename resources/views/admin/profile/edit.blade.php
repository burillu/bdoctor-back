@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <div class="card-header fs-4 text-secondary my-4">
            {{ __('Profile') }}
        </div>
        <div class="card p-4 mb-4 bg-white shadow rounded-lg">

            @include('admin.profile.partials.update-profile-information-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('admin.profile.partials.update-password-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('admin.profile.partials.delete-user-form')

        </div>
    </div>
@endsection
