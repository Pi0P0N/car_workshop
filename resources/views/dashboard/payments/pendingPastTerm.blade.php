@extends('layouts.main')

@section('content')
@goback
<div class="card">
    <div class="card-header">Zaległe Płatności</div>
    <div class="card-body">
        @if($pendingPayments->isEmpty())
            <p>Brak zaległych płatności.</p>
        @else
            <div class="table-responsive">
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
                        @foreach($pendingPayments as $payment)
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
                            <th>{{ number_format($pendingPayments->sum(fn($payment) => $payment->repair->repairtype->price), 2) }} PLN</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection