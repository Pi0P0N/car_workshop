<!-- filepath: /e:/preformat/Studia/Semestr_V/Inzynieria2/car-workshop/resources/views/dashboard/clients/clientsList.blade.php -->
@extends('layouts.main')

@section('content')
@goback
<div class="card">
    <div class="card-header">Lista Klientów</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Numer telefonu</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->first_name }}</td>
                        <td>{{ $client->last_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone_number }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary">Pokaż</a>
                                @if (App\Enums\RolesEnum::isManager())
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Edytuj</a>
                                @endif
                                @include('dashboard.utilities.openModalButton', [
                                    'btnText' => 'Usuń',
                                    'btnClass' => 'btn-danger',
                                    'modalId' => 'deleteClientModal-' . $client->id,
                                ])
                            </div>
                            <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('dashboard.utilities.modal', [
                        'modalId' => 'deleteClientModal-' . $client->id,
                        'modalLabelId' => 'deleteClientModalLabel-' . $client->id,
                        'modalTitle' => 'Usuń Klienta',
                        'modalContent' => 'Czy na pewno chcesz usunąć tego klienta?',
                        'modalSaveText' => 'Usuń',
                        'buttonStyle' => 'btn-danger',
                        'formId' => 'delete-form-' . $client->id
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection