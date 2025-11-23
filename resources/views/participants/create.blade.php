@extends('layouts.admin')

@section('content')

<div class="card w-75 mx-auto">
    <div class="card-header">
        <h4>Add Participant(s) to Event</h4>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('participants.store') }}" method="POST">
            @csrf

            <!-- EVENT -->
            <div class="mb-3">
                <label class="form-label">Select Event</label>
                <select id="eventSelect" name="event_id" class="form-control" required>
                    <option value="">-- Select Event --</option>

                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                                data-type="{{ $event->type }}"
                                data-section="{{ $event->section }}">
                            {{ $event->name }} ({{ ucfirst($event->section) }} | {{ ucfirst($event->type) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TEAM -->
            <div class="mb-3">
                <label class="form-label">Team</label>
                <select id="teamSelect" name="team" class="form-control" required>
                    <option value="">-- Select Team --</option>
                    <option value="Thuras">Thuras</option>
                    <option value="Aqeeda">Aqeeda</option>
                </select>
            </div>

            <!-- GROUP NAME BOX -->
            <div id="groupNameBox" class="mb-3" style="display:none;">
                <label class="form-label">Group Name</label>
                <input type="text" name="group_name" id="groupNameInput" class="form-control"
                       placeholder="Eg: A1, B2, DanceTeam">
            </div>

            <!-- INDIVIDUAL SECTION -->
            <div id="individualSection">
                <div id="individualMembers" class="border p-3 mb-2 bg-light"
                     style="max-height:250px; overflow-y:auto; display:none;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Chest No</label>
                    <input type="text" name="chest_no" id="indChest" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Participant Name</label>
                    <input type="text" name="name" id="indName" class="form-control">
                </div>
            </div>

            <!-- GROUP SECTION -->
            <div id="groupSection" style="display:none;">
                <label class="form-label">Select Group Members</label>

                <div id="groupMembers" class="border p-3 bg-light"
                     style="max-height:250px; overflow:auto;">
                </div>
            </div>

            <button class="btn btn-success w-100 mt-3">Save</button>
        </form>

    </div>
</div>

<script>
let fixedData = @json($fixed);

// DOM references
const eventSelect   = document.getElementById('eventSelect');
const teamSelect    = document.getElementById('teamSelect');
const groupNameBox  = document.getElementById('groupNameBox');
const groupNameInput= document.getElementById('groupNameInput');
const individualSection = document.getElementById('individualSection');
const groupSection  = document.getElementById('groupSection');
const groupMembers  = document.getElementById('groupMembers');
const individualMembers = document.getElementById('individualMembers');

eventSelect.addEventListener('change', updateUI);
teamSelect.addEventListener('change', updateUI);

function updateUI() {
    if (!eventSelect.value) return;

    const selected = eventSelect.selectedOptions[0];
    const type     = selected.dataset.type;
    const section  = selected.dataset.section;
    const team     = teamSelect.value;

    // Show group name only for group/general events
    if (type === "group" || section === "general") {
        groupNameBox.style.display = "block";
    } else {
        groupNameBox.style.display = "none";
    }

    // Do NOT CLEAR group_name automatically!
    // groupNameInput.value = "";  <-- removed

    // Reset visible sections
    if (type === "group" || section === "general") {
        groupSection.style.display = "block";
        individualSection.style.display = "none";

        if (team) loadGroupMembers(team, section);
        return;
    }

    // Individual event
    groupSection.style.display = "none";
    individualSection.style.display = "block";

    if (team) loadIndividualMembers(team, section);
}

function loadGroupMembers(team, section) {
    groupMembers.innerHTML = "";
    fixedData.forEach(p => {
        if (p.team === team && (section === "general" || p.section === section)) {
            groupMembers.innerHTML += `
                <div class="form-check">
                    <input type="checkbox" name="members[]" value="${p.id}" class="form-check-input">
                    <label class="form-check-label">${p.name} (${p.chest_no})</label>
                </div>
            `;
        }
    });
}

function loadIndividualMembers(team, section) {
    individualMembers.style.display = "block";
    individualMembers.innerHTML = "";

    fixedData.forEach(p => {
        if (p.team === team && p.section === section) {
            individualMembers.innerHTML += `
                <div class="form-check">
                    <input type="radio" name="select_individual" value="${p.id}"
                           class="form-check-input"
                           onclick="fillIndividual('${p.name}','${p.chest_no}')">
                    <label class="form-check-label">${p.name} (${p.chest_no})</label>
                </div>
            `;
        }
    });
}

function fillIndividual(name, chest) {
    document.getElementById('indName').value = name;
    document.getElementById('indChest').value = chest;
}
</script>

@endsection
