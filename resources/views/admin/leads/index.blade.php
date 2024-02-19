@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-head">Messaggi ricevuti ({{ count($leads) }})</h1>
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tel</th>
                    <th scope="col">Anteprima</th>
                    <th scope="col">Data/ora</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leads as $lead)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lead->surname }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->tel }}</td>
                        <td>{{ substr($lead->message, 0, 80) . '...' }}</td>
                        <td>{{ date('d-m-Y \O\r\e\: H:i:s', strtotime($lead->created_at)) }} </td>
                        <td class="">
                            <a class="btn btn-primary" href=" {{ route('admin.leads.show', $lead->id) }}"><i
                                    class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
