@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-header">Messaggi ricevuti ({{ count($leads) }})</h1>
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
                @foreach ($leads as $lead)
                    <tr class="text-center">

                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $lead->surname . ' ' . $lead->name }}</td>
                        <td class="d-none d-xl-table-cell">{{ $lead->email }}</td>
                        {{-- <td>{{ $lead->tel }}</td> --}}
                        <td class="d-none d-xl-table-cell">{{ substr($lead->message, 0, 40) . '...' }}</td>
                        <td>{{ date('d-m-Y \O\r\e\: H:i', strtotime($lead->created_at)) }} </td>

                        <td class="">
                            <a class="btn my-bg-contrast" href=" {{ route('admin.leads.show', $lead->id) }}"><i
                                    class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
