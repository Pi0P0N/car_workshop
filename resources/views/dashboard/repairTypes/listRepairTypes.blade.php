@extends('layouts.main')
@section('content')
@goback
<div class="card">
    <div class="card-header">Lista Typów Napraw</div>
    <div class="card-body">
        <a href="{{ route('repairTypes.create') }}" class="btn btn-primary">Dodaj nowy typ naprawy</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Czas trwania</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repairTypes as $repairType)
                    <tr>
                        <td>{{ $repairType->name }}</td>
                        <td>{{ $repairType->price }} PLN</td>
                        <td>{{ $repairType->duration }} min</td>
                        <td>
                            @if(strlen($repairType->description) > 50)
                                <span title="{{ $repairType->description }}">{{ substr($repairType->description, 0, 50) }}...</span>
                            @else
                                {{ $repairType->description }}
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('repairTypes.edit', $repairType->id) }}" class="btn btn-warning">Edytuj</a>
                                @include('dashboard.utilities.openModalButton', [
                                    'btnText' => 'Usuń',
                                    'btnClass' => 'btn-danger',
                                    'modalId' => 'deleteRepairTypeModal-' . $repairType->id,
                                ])
                            </div>
                            <form id="delete-form-{{ $repairType->id }}" action="{{ route('repairTypes.destroy', $repairType->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @include('dashboard.utilities.modal', [
                        'modalId' => 'deleteRepairTypeModal-' . $repairType->id,
                        'modalLabelId' => 'deleteRepairTypeModalLabel-' . $repairType->id,
                        'modalTitle' => 'Usuń Typ Naprawy',
                        'modalContent' => 'Czy na pewno chcesz usunąć ten typ naprawy?',
                        'modalSaveText' => 'Usuń',
                        'buttonStyle' => 'btn-danger',
                        'formId' => 'delete-form-' . $repairType->id
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection