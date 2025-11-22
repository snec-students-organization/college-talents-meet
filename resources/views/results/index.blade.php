@extends('layouts.admin')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="fw-bold">Event Results</h4>
        <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">← Back to Events</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Stage/Offstage</th>
                    <th>Type</th>
                    <th>View Results</th>
                </tr>
            </thead>

            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ ucfirst($event->section) }}</td>
                    <td>{{ $event->category }}</td>
                    <td>{{ ucfirst($event->stage_type) }}</td>
                    <td>{{ ucfirst($event->type) }}</td>

                    <td>
                        <a href="{{ route('results.event', $event->id) }}"
                           class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
