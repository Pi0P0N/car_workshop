@extends('layouts.main')
@section('content')
@goback
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edytuj Naprawę</div>
            <div class="card-body">
                <form method="POST" action="{{ route('repairs.update', ['id' => $repair->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control mt-1" required>
                            @foreach (App\Enums\RepairStatusEnum::getAll() as $status)
                                <option value="{{ $status }}" @if($status == $repair->status->value) selected @endif>{{ App\Enums\RepairStatusEnum::getLabel($status->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="scheduled_date">Data</label>
                        <input type="date" class="form-control mt-1" id="scheduled_date" name="scheduled_date" value="{{ $repair->scheduled_date }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="repair_type">Typ usługi</label>
                        <select name="repair_type" id="repair_type" class="form-control mt-1" required>
                            @foreach ($repairTypes as $repairType)
                                <option value="{{ $repairType->id }}" @if($repairType->id == $repair->repair_type_id) selected @endif>{{ $repairType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="scheduled_time">Godzina</label>
                        <select class="form-control mt-1" id="scheduled_time" name="scheduled_time" required>
                            <option value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $repair->scheduled_time)->format('H:i') }}" selected>{{ \Carbon\Carbon::createFromFormat('H:i:s', $repair->scheduled_time)->format('H:i') }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Opis</label>
                        <textarea class="form-control mt-1" id="description" name="description" rows="3" required>{{ $repair->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="submit_button">Zapisz zmiany</button>
                    <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function fetchAvailableTimes() {
        var date = document.getElementById('scheduled_date').value;
        var repairType = document.getElementById('repair_type').value;
        var submitButton = document.getElementById('submit_button');
        var selectedTime = document.getElementById('scheduled_time').value.split(':').slice(0, 2).join(':');
        
        if (date && repairType) {
            submitButton.disabled = true;
            fetch('{{ route('repairs.available-times') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ date: date, repair_type: repairType, repair_id: {{ $repair->id }} })
            })
            .then(response => response.json())
            .then(data => {
                var timeSelect = document.getElementById('scheduled_time');
                timeSelect.innerHTML = '';
                var isSelectedTimeAvailable = false;
                data.forEach(function(time) {
                    var option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    if (time === selectedTime) {
                        option.selected = true;
                        isSelectedTimeAvailable = true;
                    }
                    timeSelect.appendChild(option);
                });
                if (!isSelectedTimeAvailable && data.length > 0) {
                    timeSelect.value = data[0];
                }
                submitButton.disabled = false;
            })
            .catch(() => {
                submitButton.disabled = false;
            });
        }
    }

    document.getElementById('scheduled_date').addEventListener('change', fetchAvailableTimes);
    document.getElementById('repair_type').addEventListener('change', fetchAvailableTimes);
    fetchAvailableTimes();
</script>
@endsection