@extends('layouts.main')
@section('content')
@goback
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edytuj Pracownika</div>
            <div class="card-body">
                <form method="POST" action="{{ route('employees.update', ['id' => $employee->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="first_name">Imię</label>
                        <input type="text" class="form-control mt-1" id="first_name" name="first_name" value="{{ $employee->first_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="last_name">Nazwisko</label>
                        <input type="text" class="form-control mt-1" id="last_name" name="last_name" value="{{ $employee->last_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" value="{{ $employee->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="role">Rola</label>
                        <select name="role" id="role" class="form-control mt-1" required>
                            @foreach (App\Enums\RolesEnum::getAll() as $role)
                                <option value="{{ $role }}" @if($role == $employee->role) selected @endif>{{ App\Enums\RolesEnum::getLabel($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Zapisz zmiany</button>
                    <input type="hidden" name="id" value="{{ $employee->id }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection