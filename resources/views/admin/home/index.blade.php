@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-head">Benvenuto, {{ Auth::user()->name }}</h1>
        <table class="table table-hover">
            <thead>
                <tr class="text-center">

                    {{-- <th scope="col">#</th> --}}
                    <th scope="col">Cognome e Nome</th>

                    <th class="d-none d-xl-table-cell" scope="col">Email</th>
                    {{-- <th scope="col">Tel</th> --}}
                    <th class="d-none d-xl-table-cell" scope="col">Anteprima</th>

                    <th scope="col">Data/ora</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
@endsection
