@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Zaloguj się') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">{{ __('Adres e-mail') }}</label>
                            <input type="email" class="form-control mt-1" id="email" name="email" required autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">{{ __('Hasło') }}</label>
                            <input type="password" class="form-control mt-1" id="password" name="password" required>
                        </div>
                        <div class="form-group mb-3 form-check my-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">{{ __('Zapamiętaj mnie') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Zaloguj się') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection