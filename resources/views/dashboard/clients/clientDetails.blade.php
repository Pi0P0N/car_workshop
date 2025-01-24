@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Szczegóły Klienta</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group my-1">
                    <label for="name">Imię i Nazwisko</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}" disabled>
                </div>
                <div class="form-group my-1">
                    <label for="email">Adres e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}" disabled>
                </div>
                <div class="form-group my-1">
                    <label for="phone">Numer telefonu</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone_number }}" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Naprawy</div>
    <div class="card-body">
        {{-- if $repairs not empty --}}
        @if(isset($client->repairs) && $client->repairs->isNotEmpty())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Termin</th>
                    <th scope="col">Usługa</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Status</th>
                    <th scope="col">Koszt</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($client->repairs as $repair)
                    <tr>
                        <td>{{ $repair->date }}</td>
                        <td>{{ $repair->employee->name }}</td>
                        <td>{{ $repair->description }}</td>
                        <td>{{ $repair->cost }}</td>
                    </tr>
                @endforeach --}}
                @foreach($client->repairs as $repair)
                    <tr>
                        <td>{{ $repair->scheduled_date }} <b>{{ \Carbon\Carbon::parse($repair->scheduled_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($repair->scheduled_time)->addMinutes($repair->repairType->duration)->format('H:i') }}</b></td>
                        <td>{{ $repair->repairType->name }}</td>
                        <td>{{ $repair->description }}</td>
                        <td>{{ \App\Enums\RepairStatusEnum::getLabel($repair->status->value) }}</td>
                        <td>{{ $repair->repairType->price }} PLN</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Brak napraw</p>
        @endif
</div>
@endsection