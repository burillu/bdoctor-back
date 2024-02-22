@extends('layouts.app')
@section('header')
    @include('partials.header')
@endsection
@section('content')
    <main class="my-bg-primary vh-100">
        <section class="container">
            @if (Route::has('register'))
            @else
                <h1>Accedi o Registrati</h1>
            @endif


        </section>
    </main>
@endsection
