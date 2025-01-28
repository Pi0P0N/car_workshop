@extends('layouts.main')
@section('content')
<h3>Płatności</h3>
<div class="row">
    <div class="col-md-4 my-3">
        <div class="card">
            <div class="card-header">Konkretny dzień</div>
            <div class="card-body">
                <p>Przejrzyj płatności na dany dzień</p>
                <a href="{{ route('payments.day') }}" class="btn btn-primary">Przeglądaj</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 my-3">
        <div class="card">
            <div class="card-header">Podsumowanie miesiąca</div>
            <div class="card-body">
                <p>Zobacz podsumowanie miesiąca</p>
                <a href="{{ route('payments.summary') }}" class="btn btn-primary">Przeglądaj</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 my-3">
        <div class="card">
            <div class="card-header">Zaległe zapłaty</div>
            <div class="card-body">
                <p>Lista zaległych zapłat</p>
                <a href="{{ route('payments.pending') }}" class="btn btn-primary">Przeglądaj</a>
            </div>
        </div>
    </div>
</div>
@endsection