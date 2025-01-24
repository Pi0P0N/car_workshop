@extends('layouts.main')
@section('content')
{{-- add panels to go to, for example clients list --}}
<div class="row">
    <div class="col-md-4 my-3">
        <div class="card">
            <div class="card-header">Klienci</div>
            <div class="card-body">
                <p>Przejrzyj listę klientów</p>
                <a href="{{ route('clients.list') }}" class="btn btn-primary">Lista Klientów</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 my-3">
        <div class="card">
            <div class="card-header">Naprawy</div>
            <div class="card-body">
                <p>Lista napraw</p>
                <a href="{{ route('repairs.list') }}" class="btn btn-primary">Lista Napraw</a>
            </div>
        </div>
    </div>
    @if (App\Enums\RolesEnum::isManager())
        <div class="col-md-4 my-3">
            <div class="card">
                <div class="card-header">Pracownicy</div>
                <div class="card-body">
                    <p>Przejrzyj listę pracowników</p>
                    {{-- <a href="{{ route('repairs.index') }}" class="btn btn-primary">Lista Napraw</a> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4 my-3">
            <div class="card">
                <div class="card-header">Usługi</div>
                <div class="card-body">
                    <p>Zarządzaj dostępnymi usługami</p>
                    {{-- <a href="{{ route('repairs.index') }}" class="btn btn-primary">Lista Napraw</a> --}}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection