@extends('layouts.main')

@section('content')
    <h1 class="display-4">Witaj w naszym warsztacie!</h1>
    <p class="lead">Zajmujemy się kompleksową naprawą i serwisem samochodów.</p>
    <hr class="my-3">
    <p>Oferujemy szeroki zakres usług, od drobnych napraw po kompleksowe remonty.</p>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($cardsInfo as $cardInfo)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $cardInfo->name }}</h5>
                        <p class="card-text flex-grow-1">{{ $cardInfo->description }}</p>
                        <a href="/addRepair" class="btn btn-primary mt-auto">Umów się na wizytę</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection