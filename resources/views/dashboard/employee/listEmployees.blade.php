@extends('layouts.main')

@section('content')
@goback
    <div class="card">
        <div class="card-header">Lista Pracowników</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edytuj</a>
                                    @include('dashboard.utilities.openModalButton', [
                                        'btnText' => 'Usuń',
                                        'btnClass' => 'btn-danger',
                                        'modalId' => 'deleteEmployeeModal-' . $employee->id,
                                    ])
                                </div>
                                <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @include('dashboard.utilities.modal', [
                            'modalId' => 'deleteEmployeeModal-' . $employee->id,
                            'modalLabelId' => 'deleteEmployeeModalLabel-' . $employee->id,
                            'modalTitle' => 'Usuń Pracownika',
                            'modalContent' => 'Czy na pewno chcesz usunąć tego pracownika?',
                            'modalSaveText' => 'Usuń',
                            'buttonStyle' => 'btn-danger',
                            'formId' => 'delete-form-' . $employee->id
                        ])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection