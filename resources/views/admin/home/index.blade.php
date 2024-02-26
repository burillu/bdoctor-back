@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <div class="card-header fs-4 text-secondary">
            Pagina Iniziale
        </div>
        <h1 class="">Benvenuto, {{ Auth::user()->name }}!</h1>


    </div>
@endsection
