@extends('layouts.admin')

@section('content')

<div class="card w-75 mx-auto">
    <div class="card-header">
        <h4>Add Event</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <!-- EVENT NAME -->
            <div class="mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- SECTION + CATEGORY -->
            <div class="row mb-3">

                <div class="col">
                    <label class="form-label">Section</label>
                    <select id="sectionSelect" name="section" class="form-control" required>
                        <option value="junior">Junior</option>
                        <option value="senior">Senior</option>
                        <option value="general">General (Open)</option>
                    </select>
                </div>

                <div class="col">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control" required>
                        <option>A</option>
                        <option>B</option>
                        <option>C</option>
                        <option>D</option>
                    </select>
                </div>
            </div>

            <!-- EVENT TYPE (HIDDEN WHEN GENERAL IS SELECTED) -->
            <div class="row mb-3">

                <div class="col" id="typeBox">
                    <label class="form-label">Event Type</label>
                    <select name="type" id="typeSelect" class="form-control" required>
                        <option value="individual">Individual</option>
                        <option value="group">Group</option>
                    </select>
                </div>

                <div class="col">
                    <label class="form-label">Stage / Offstage</label>
                    <select name="stage_type" class="form-control" required>
                        <option value="stage">Stage</option>
                        <option value="offstage">Off Stage</option>
                    </select>
                </div>

            </div>

            <input type="hidden" id="forcedType" name="forced_type">

            <button class="btn btn-success px-4">Save Event</button>

        </form>

    </div>
</div>

<script>
document.getElementById('sectionSelect').addEventListener('change', function () {
    let section = this.value;

    let typeBox = document.getElementById('typeBox');
    let typeSelect = document.getElementById('typeSelect');
    let forcedType = document.getElementById('forcedType');

    if (section === "general") {
        typeBox.style.display = "none";
        forcedType.value = "group";
    } else {
        typeBox.style.display = "block";
        forcedType.value = "";
    }
});
</script>

@endsection
