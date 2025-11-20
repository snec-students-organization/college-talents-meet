@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Events</h4>
        <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
            + Add Event
        </a>
    </div>

    <div class="card-body">

        <!-- FILTER FORM -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="stage_type" class="form-control">
                        <option value="">All (Stage + Offstage)</option>
                        <option value="stage" {{ request('stage_type') == 'stage' ? 'selected' : '' }}>Stage</option>
                        <option value="offstage" {{ request('stage_type') == 'offstage' ? 'selected' : '' }}>Offstage</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark">Filter</button>
                </div>
            </div>
        </form>

        <!-- EVENTS TABLE -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Stage Type</th>
                </tr>
            </thead>

            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ ucfirst($event->section) }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ ucfirst($event->type) }}</td>
                    <td>{{ ucfirst($event->stage_type) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
