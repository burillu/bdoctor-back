@extends('admin.dashboard')
@section('dashboard_content')
    <div class="container">
        <h1 class="card-head">Recensioni :</h1>
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Anteprima</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $review->name }}</td>
                        <td>{{ $review->email }}</td>
                        <td>{{ $review->title }} </td>
                        <td>{{ substr($review->body, 0, 80) . '...' }}</td>

                        <td class="">
                            <a class="btn btn-primary" href=" {{ route('admin.reviews.show', $review->id) }}"><i
                                    class="fa-regular fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
