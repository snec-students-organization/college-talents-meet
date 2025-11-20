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
                    <select name="section" class="form-control" required>
                        <option value="junior">Junior</option>
                        <option value="senior">Senior</option>
                        <option value="general">General</option> <!-- NEW -->
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

            <!-- TYPE + STAGE OPTION -->
            <div class="row mb-3">

                <div class="col">
                    <label class="form-label">Event Type</label>
                    <select name="type" class="form-control" required>
                        <option value="individual">Individual</option>
                        <option value="group">Group</option>
                        <option value="general">General</option> <!-- Already Here -->
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

            <button class="btn btn-success px-4">Save Event</button>

        </form>

    </div>
</div>

@endsection
