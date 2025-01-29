@extends('layouts.main')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dodaj Naprawę</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('storeRepair') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="scheduled_date">Data</label>
                            <input type="date" class="form-control mt-1" id="scheduled_date" name="scheduled_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="repair_type">Typ usługi</label>
                            <select name="repair_type" id="repair_type" class="form-control mt-1" required>
                                @foreach ($repairTypes as $repairType)
                                    <option value="{{ $repairType->id }}" {{ $repairType->id == $selectedRepairType ? 'selected' : '' }}>
                                        {{ $repairType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="scheduled_time">Godzina</label>
                            <select class="form-control mt-1" id="scheduled_time" name="scheduled_time" required>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Opis</label>
                            <textarea class="form-control mt-1" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <span id="not-available" class="d-none text-danger">Niestety, brak dostępnych terminów na wybraną datę i typ naprawy.</span>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary mt-3" id="submit_button">Dodaj Naprawę</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function fetchAvailableTimes() {
        var date = document.getElementById('scheduled_date').value;
        var repairType = document.getElementById('repair_type').value;
        var submitButton = document.getElementById('submit_button');
        var notAvailableMessage = document.getElementById('not-available');
        
        if (date && repairType) {
            submitButton.disabled = true;
            fetch('{{ route('repairs.available-times') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ date: date, repair_type: repairType })
            })
            .then(response => response.json())
            .then(data => {
                var timeSelect = document.getElementById('scheduled_time');
                timeSelect.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(function(time) {
                        var option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeSelect.appendChild(option);
                    });
                    submitButton.disabled = false;
                    notAvailableMessage.classList.add('d-none');
                } else {
                    submitButton.disabled = true;
                    notAvailableMessage.classList.remove('d-none');
                }
            })
            .catch(() => {
                submitButton.disabled = true;
                notAvailableMessage.classList.remove('d-none');
            });
        } else {
            submitButton.disabled = true;
            notAvailableMessage.classList.add('d-none');
        }
    }

    document.getElementById('scheduled_date').addEventListener('change', fetchAvailableTimes);
    document.getElementById('repair_type').addEventListener('change', fetchAvailableTimes);
</script>
@endsection