@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Edytuj typ naprawy</div>
    <div class="card-body">
        <form action="{{ route('repairTypes.update', $repairType->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Nazwa</label>
                <input type="text" class="form-control mt-1" id="name" name="name" value="{{ $repairType->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="price">Cena</label>
                <input type="number" class="form-control mt-1" id="price" name="price" value="{{ number_format($repairType->price, 2) }}" min="0" step="10" required oninput="this.value = parseFloat(this.value).toFixed(2)">
            </div>
            <div class="form-group mb-3">
                <label for="duration">Czas trwania</label>
                <input type="number" class="form-control mt-1" id="duration" name="duration" value="{{ $repairType->duration }}" min="30" step="30" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Opis</label>
                <textarea class="form-control mt-1" id="description" name="description" rows="3" required>{{ $repairType->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
</div>
@endsection