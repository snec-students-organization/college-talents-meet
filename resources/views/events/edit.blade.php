@extends('layouts.admin')

@section('content')

<div class="card w-75 mx-auto">
    <div class="card-header">
        <h4>Edit Event</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Section</label>
                    <select name="section" class="form-control">
                        <option value="junior"  {{ $event->section=='junior'?'selected':'' }}>Junior</option>
                        <option value="senior"  {{ $event->section=='senior'?'selected':'' }}>Senior</option>
                        <option value="general" {{ $event->section=='general'?'selected':'' }}>General</option>
                    </select>
                </div>

                <div class="col">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control">
                        <option {{ $event->category=='A'?'selected':'' }}>A</option>
                        <option {{ $event->category=='B'?'selected':'' }}>B</option>
                        <option {{ $event->category=='C'?'selected':'' }}>C</option>
                        <option {{ $event->category=='D'?'selected':'' }}>D</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="individual" {{ $event->type=='individual'?'selected':'' }}>Individual</option>
                        <option value="group" {{ $event->type=='group'?'selected':'' }}>Group</option>
                    </select>
                </div>

                <div class="col">
                    <label class="form-label">Stage Type</label>
                    <select name="stage_type" class="form-control">
                        <option value="stage" {{ $event->stage_type=='stage'?'selected':'' }}>Stage</option>
                        <option value="offstage" {{ $event->stage_type=='offstage'?'selected':'' }}>Offstage</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-success">Update</button>

        </form>

    </div>
</div>

@endsection
