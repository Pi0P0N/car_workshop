@extends('layouts.main')

@section('content')
@goback
    <div class="card">
        <div class="card-header">Lista Klientów</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->first_name }}</td>
                            <td>{{ $client->last_name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary">Pokaż</a>
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection