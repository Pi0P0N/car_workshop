@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Dodaj nowy typ naprawy</div>
    <div class="card-body">
        <form action="{{ route('repairTypes.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Nazwa</label>
                <input type="text" class="form-control mt-1" id="name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="price">Cena</label>
                <input type="number" class="form-control mt-1" id="price" name="price" min="0" step="10" required>
            </div>
            <div class="form-group mb-3">
                <label for="duration">Czas trwania</label>
                <input type="number" class="form-control mt-1" id="duration" name="duration" min="30" step="30" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Opis</label>
                <textarea class="form-control mt-1" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
    </div>
</div>
@endsection