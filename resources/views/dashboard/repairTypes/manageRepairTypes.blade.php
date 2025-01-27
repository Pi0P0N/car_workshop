@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Lista Typów Napraw</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Czas trwania</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repairTypes as $repairType)
                    <tr>
                        <td>{{ $repairType->name }}</td>
                        <td>{{ $repairType->price }}</td>
                        <td>{{ $repairType->duration }}</td>
                        <td>
                            <a href="{{ route('repairTypes.show', $repairType->id) }}" class="btn btn-primary">Pokaż</a>
                            <a href="{{ route('repairTypes.edit', $repairType->id) }}" class="btn btn-warning">Edytuj</a>

                        </td>
                        <form action="{{ route('repairTypes.destroy', $repairType->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection