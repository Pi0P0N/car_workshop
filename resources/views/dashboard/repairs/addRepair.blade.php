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
                        <div class="form-group">
                            <label for="scheduled_date">Data</label>
                            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="repair_type">Typ usługi</label>
                            <select name="repair_type" id="repair_type" class="form-control" required>
                                @foreach ($repairTypes as $repairType)
                                    <option value="{{ $repairType->id }}">{{ $repairType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="scheduled_time">Godzina</label>
                            <select class="form-control" id="scheduled_time" name="scheduled_time" required>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Opis</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" id="submit_button">Dodaj Naprawę</button>
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
                data.forEach(function(time) {
                    var option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });
                submitButton.disabled = false;
            })
            .catch(() => {
                submitButton.disabled = false;
            });
        }
    }

    document.getElementById('scheduled_date').addEventListener('change', fetchAvailableTimes);
    document.getElementById('repair_type').addEventListener('change', fetchAvailableTimes);
</script>
@endsection