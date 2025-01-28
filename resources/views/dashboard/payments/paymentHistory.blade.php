@extends('layouts.main')

@section('content')
@goback
<div class="card">
    <div class="card-header">Historia Płatności</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Wersja</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data Utworzenia</th>
                        <th scope="col">Pracownik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentHistory as $payment)
                        <tr>
                            <td>{{ $payment->version }}</td>
                            <td>{{ App\Enums\PaymentStatusEnum::getLabel($payment->status->value) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d H:i') }}</td>
                            <td>{{ $payment->employee ? $payment->employee->first_name . ' ' . $payment->employee->last_name : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection