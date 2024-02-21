@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-header mb-4">Recensione da parte di: {{ $review->name }}</h1>
        <h5>Contatti: </h5>
        <div class="mb-4">

            <div>Email :{{ $review->email }}</div>
        </div>
        <div class="mb-4 border rounded-2 p-3">
            @if ($review->title)
                <h5>Titolo: {{ $review->title }}</h5>
            @endif

            <h6>Recensione:</h6>
            <p>{{ $review->body }}</p>
            <div> Data : {{ date('d/m/Y \|\ \O\r\a\: H:i', strtotime($review->created_at)) }}</div>
        </div>
        <button class="btn my-bg-contrast mb-4"> <a href="{{ route('admin.reviews.index') }}"> <i
                    class="fa-solid fa-arrow-left"></i>
                Ritorna alle recensioni</a></button>
    </div>
@endsection
