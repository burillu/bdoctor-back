@extends('admin.dashboard')
@section('dashboard_content')
    <div class="card-header fs-4 text-secondary">
        Acquista la tuo abbonamento
    </div>
    @if (str_contains(url()->current(), '/sponsorships'))
        @include('admin.payments.form')
    @endif
@endsection
