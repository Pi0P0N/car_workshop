@extends('layouts.main')

@section('content')
@goback
    <div class="card">
        <div class="card-header">Lista Napraw</div>
        <div class="card-body">
            {{-- previous day, datepicker and next day --}}
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('repairs.list', ['date' => $previousDay]) }}" class="btn btn-primary">Poprzedni dzień</a>
                <form action="{{ route('repairs.list') }}" method="GET" id="dateForm">
                    <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="document.getElementById('dateForm').submit();">
                </form>
                <a href="{{ route('repairs.list', ['date' => $nextDay]) }}" class="btn btn-primary">Następny dzień</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Godzina</th>
                        <th scope="col">Rodzaj usługi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Imię i nazwisko</th>
                        <th scope="col">Numer telefonu</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($repairs as $repair)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($repair->scheduled_time)->format('H:i') }}</td>
                            <td>{{ $repair->repairType->name }}</td>
                            <td>{{ App\Enums\RepairStatusEnum::getLabel($repair->status->value) }}</td>
                            <td>{{ $repair->client->first_name }} {{ $repair->client->last_name }}</td>
                            <td><a href="tel:{{ $repair->client->phone_number }}">{{ $repair->client->phone_number }}</a></td>
                            <td><a href="{{ route('repairs.edit', ['id' => $repair->id]) }}" class="btn btn-primary">Edytuj</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection