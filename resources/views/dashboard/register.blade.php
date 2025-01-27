@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Rejestracja</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="first_name">Imię</label>
                            <input type="text" class="form-control mt-1" id="first_name" name="first_name" required autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <label for="last_name">Nazwisko</label>
                            <input type="text" class="form-control mt-1" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Adres e-mail</label>
                            <input type="email" class="form-control mt-1" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Hasło</label>
                            <input type="password" class="form-control mt-1" id="password" name="password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password-confirm">Powtórz hasło</label>
                            <input type="password" class="form-control mt-1" id="password-confirm" name="password_confirmation" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number">Numer telefonu</label>
                            <input type="text" class="form-control mt-1" id="phone_number" name="phone_number" pattern="[0-9]{9}" required>
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Zarejestruj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection