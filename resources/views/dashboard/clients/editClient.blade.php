<!-- filepath: /e:/preformat/Studia/Semestr_V/Inzynieria2/car-workshop/resources/views/dashboard/clients/editClient.blade.php -->
@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Edytuj Szczegóły Klienta</div>
    <div class="card-body">
        <form method="POST" action="{{ route('clients.update', ['id' => $client->id]) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group my-1">
                        <label for="first_name">Imię</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $client->first_name }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="last_name">Nazwisko</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $client->last_name }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="email">Adres e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="phone_number">Numer telefonu</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $client->phone_number }}" required>
                    </div>
                    <div class="form-group my-1">
                        <label for="role">Rola</label>
                        <select name="role" id="role" class="form-control" required>
                            @foreach (App\Enums\RolesEnum::getAll() as $role)
                                <option value="{{ $role }}" @if($role == $client->role) selected @endif>{{ App\Enums\RolesEnum::getLabel($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="id" value="{{ $client->id }}">
                    <button type="submit" class="btn btn-primary mt-3">Zapisz zmiany</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection