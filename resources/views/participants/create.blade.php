@extends('layouts.admin')

@section('content')

<div class="card w-75 mx-auto">
    <div class="card-header">
        <h4>Add Participant to Event</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('participants.store') }}" method="POST">
            @csrf

            <!-- Team -->
            <div class="mb-3">
                <label class="form-label">Team</label>
                <select id="teamSelect" class="form-control" required>
                    <option value="">-- Select Team --</option>
                    <option value="Thuras">Thuras</option>
                    <option value="Aqeeda">Aqeeda</option>
                </select>
            </div>

            <!-- Participant List -->
            <div class="mb-3">
                <label class="form-label">Select Participant</label>
                <select name="fixed_id" id="participantSelect" class="form-control" required>
                    <option value="">-- Select Participant --</option>

                    @foreach($fixed as $p)
                        <option value="{{ $p->id }}" data-team="{{ $p->team }}" data-chest="{{ $p->chest_no }}">
                            {{ $p->name }} ({{ $p->chest_no }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Auto Chest No -->
            <div class="mb-3">
                <label class="form-label">Chest No</label>
                <input type="text" id="chestNo" class="form-control" readonly>
            </div>

            <!-- EVENT -->
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-control" required>
                    <option value="">-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success px-4">Save</button>

        </form>

    </div>
</div>

<script>
document.getElementById('teamSelect').addEventListener('change', function() {
    let team = this.value;
    let options = document.querySelectorAll('#participantSelect option');

    options.forEach(opt => {
        if (opt.value === "") return; 

        opt.style.display = (opt.dataset.team === team) ? 'block' : 'none';
    });
});

document.getElementById('participantSelect').addEventListener('change', function() {
    let chest = this.selectedOptions[0].dataset.chest;
    document.getElementById('chestNo').value = chest;
});
</script>

@endsection
