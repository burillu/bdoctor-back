@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-header">Benvenuto, {{ Auth::user()->name }}</h1>


    </div>
@endsection
