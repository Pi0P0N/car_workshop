@extends('layouts.main')

@section('content')
@goback
<div class="card">
    <div class="card-header">Lista Płatności</div>
    <div class="card-body">
        {{-- previous day, datepicker and next day --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('payments.day', ['date' => $previousDay]) }}" class="btn btn-primary">Poprzedni dzień</a>
            <form action="{{ route('payments.day') }}" method="GET" id="dateForm">
                <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="document.getElementById('dateForm').submit();">
            </form>
            <a href="{{ route('payments.day', ['date' => $nextDay]) }}" class="btn btn-primary">Następny dzień</a>
        </div>
        @if($payments->isEmpty())
            <p>Brak płatności tego dnia.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Godzina</th>
                        <th scope="col">Rodzaj usługi</th>
                        <th scope="col">Status płatności</th>
                        <th scope="col">Imię i nazwisko</th>
                        <th scope="col">Numer telefonu</th>
                        <th scope="col">Kwota</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('H:i') }}</td>
                            <td>{{ $payment->repair->repairType->name }}</td>
                            <td>{{ App\Enums\PaymentStatusEnum::getLabel($payment->status->value) }}</td>
                            <td>{{ $payment->repair->client->first_name }} {{ $payment->repair->client->last_name }}</td>
                            <td><a href="tel:{{ $payment->repair->client->phone_number }}">{{ $payment->repair->client->phone_number }}</a></td>
                            <td>{{ $payment->repair->repairtype->price }} PLN</td>
                            <td>
                                <div class="btn-group"> 
                                    <button type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-expanded="false">
                                        Zmień status
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($paymentStatuses as $key => $paymentStatus)
                                            @if ($payment->status->value == $key)
                                                @continue
                                            @endif
                                            <li>
                                                <form action="{{ route('payments.update', ['payment' => $payment->id]) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="status" value="{{ $key }}">
                                                    <input type="hidden" name="repair_id" value="{{ $payment->repair->id }}">
                                                    <button type="submit" class="dropdown-item">{{ $paymentStatus }}</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('payments.history', ['repair_id' => $payment->repair_id]) }}" class="btn btn-secondary">Historia</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Suma:</th>
                        <th>{{ number_format($payments->sum(fn($payment) => $payment->repair->repairtype->price), 2) }} PLN</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
@endsection