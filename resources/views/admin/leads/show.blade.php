@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-header mb-4">Messaggio da parte di: {{ $lead->name . ' ' . $lead->surname }}</h1>
        <h5>Contatti: </h5>
        <div class="mb-4">
            <div> Data : {{ date('d-m-Y \|\ \O\r\a\: H:i', strtotime($lead->created_at)) }}</div>

            <div>Email :{{ $lead->email }}</div>
            <div>Telefono: {{ $lead->tel }}</div>
        </div>
        <div class="mb-4 border rounded-2 p-3">
            <h5>Messaggio:</h5>
            <p>{{ $lead->message }}</p>
        </div>
        <button class="btn my-bg-contrast mb-4"> <a href="{{ route('admin.leads.index') }}"> <i
                    class="fa-solid fa-arrow-left"></i>
                Ritorna ai messaggi</a></button>




    </div>
@endsection
