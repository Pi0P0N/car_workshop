@extends('layouts.main')

@section('content')
@goback
<div class="card">
    <div class="card-header">Lista Napraw</div>
    <div class="card-body">
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
                    <th scope="col">Status usługi</th>
                    <th scope="col">Status płatności</th>
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
                        <td>{{ App\Enums\PaymentStatusEnum::getLabel($repair->payment->status->value) }}</td>
                        <td>{{ $repair->client->first_name }} {{ $repair->client->last_name }}</td>
                        <td><a href="tel:{{ $repair->client->phone_number }}">{{ $repair->client->phone_number }}</a></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-expanded="false">
                                    Płatność
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($paymentStatuses as $key => $paymentStatus)
                                        @if ($repair->payment->status->value == $key)
                                            @continue
                                        @endif
                                        <li>
                                            <form action="{{ route('payments.update', ['payment' => $repair->payment->id]) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                                                <input type="hidden" name="status" value="{{ $key }}">
                                                <button type="submit" class="dropdown-item">{{ $paymentStatus }}</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <a href="{{ route('repairs.edit', ['id' => $repair->id]) }}" class="btn btn-warning">Edytuj</a>
                                @include('dashboard.utilities.openModalButton', [
                                    'btnText' => 'Usuń',
                                    'btnClass' => 'btn-danger',
                                    'modalId' => 'deleteRepairModal-' . $repair->id,
                                ])
                            </div>
                            <form id="delete-form-{{ $repair->id }}" action="{{ route('repairs.destroy', ['id' => $repair->id]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    
                @include('dashboard.utilities.modal', [
                    'modalId' => 'deleteRepairModal-' . $repair->id,
                    'modalLabelId' => 'deleteRepairModalLabel-' . $repair->id,
                    'modalTitle' => 'Usuń Naprawę',
                    'modalContent' => 'Czy na pewno chcesz usunąć tę naprawę?',
                    'modalSaveText' => 'Usuń',
                    'buttonStyle' => 'btn-danger',
                    'formId' => 'delete-form-' . $repair->id
                ])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection