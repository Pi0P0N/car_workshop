@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-header">Podsumowanie płatności za miesiąc: {{ $month }}</div>
    <div class="px-5">
        <div class="d-flex justify-content-between my-3">
            <a href="{{ route('payments.summary', ['month' => \Carbon\Carbon::parse($month)->subMonth()->format('Y-m')]) }}" class="btn btn-primary">Poprzedni miesiąc</a>
            <form action="{{ route('payments.summary') }}" method="GET" id="monthForm">
                <input type="month" name="month" value="{{ $month }}" class="form-control" onchange="document.getElementById('monthForm').submit();">
            </form>
            <a href="{{ route('payments.summary', ['month' => \Carbon\Carbon::parse($month)->addMonth()->format('Y-m')]) }}" class="btn btn-primary">Następny miesiąc</a>
        </div>
        <div class="card mb-3">
            <div class="card-header">Podsumowanie płatności</div>
            <div class="card-body">
                @if(count($summary) > 0)
                    <ul>
                        @foreach($summary as $status => $count)
                            <li>{{ $status }}: {{ $count }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Brak danych do wyświetlenia</p>
                @endif
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">Szczegóły</div>
            <div class="card-body">
                <p>Łączna liczba napraw: {{ $totalRepairs }}</p>
                <p>Łączne zarobki: {{ $totalEarnings }} PLN</p>
            </div>
        </div>
    </div>
</div>
@endsection