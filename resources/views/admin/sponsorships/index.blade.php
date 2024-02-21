@extends('admin.dashboard')
@section('dashboard_content')
    <h2 class="mb-5 card-header">Acquista la tua Sponsorizzazione</h2>
    @if (str_contains(url()->current(), '/sponsorships'))
        @include('admin.payments.form')
    @endif
@endsection
